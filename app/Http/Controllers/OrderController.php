<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->id_level == 4) {
            $orders = Order::where('created_by', $user->id)->get();
        } else {
            $orders = Order::all();
        }
        $menus = Menu::all();
        $table = Table::all();

        return view('pages.order.index', ['order' => $orders, 'menus' => $menus, 'table' => $table]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_meja' => 'required|string|max:255',
            'nama_pelanggan' => 'required|string|max:255',
        ]);
        $user = Auth::user();

        $order = Order::create([
            'id_meja' => $validatedData['nomor_meja'],
            'nama_pelanggan' => $validatedData['nama_pelanggan'],
            'total' => 0,
            'bayar' => 0,
            'status' => 'Pending',
            'created_by' => $user->id,
        ]);

        $id = $order->id;

        if (auth()->check() && auth()->user()->id_level == 4) {
            LogActivity::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Created Order',
            ]);
        }

        $table_id =  $validatedData['nomor_meja'];
        $table = Table::findOrFail($table_id);

        $table->status = 'In Use';
        $table->dipesan_oleh = $validatedData['nama_pelanggan'];

        $table->save();

        return redirect()->route('detail-order', ['id' => $id]);
    }

    public function order(string $id)
    {
        $menus = Menu::all();
        $order = Order::findOrFail($id);
        $detailOrders = $order->detailOrders;
        return view('pages.order.detail', compact('menus', 'order', 'detailOrders'));
    }

    public function submitOrder(Request $request, $id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'qty' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $menuId = $request->input('menu_id');
        $qty = $request->input('qty');

        $order->menus()->sync([$menuId => ['qty' => $qty]], false);

        $totalHarga = $order->menus->sum(function ($menu) {
            return $menu->harga * $menu->pivot->qty;
        });

        $order->update(['total' => $totalHarga]);

        return redirect()->route('detail-order', ['id' => $id])->with('success', 'Order submitted successfully!');
    }


    public function viewOrderDetail($id)
    {
        $order = Order::with('menus')->findOrFail($id);

        return view('pages.order.viewdetail', ['order' => $order]);
    }

    public function statusUpdate(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'bayar' => 'required|numeric|min:' . $order->total
        ], [
            'bayar.min' => 'The payment amount must be at least equal to the total amount.'
        ]);

        $order->bayar = $request->bayar;
        $order->save();

        if ($order->status == 'Pending') {
            $order->update(['status' => 'Completed']);
        } else {
            $order->update(['status' => 'Pending']);
        }

        $table_id = $order->id_meja;
        $table = Table::findOrFail($table_id);

        if ($table->status == 'In Use') {
            $table->update(['status' => 'Available', 'dipesan_oleh' => null]);
        }

        if (auth()->check() && auth()->user()->id_level == 3) {
            LogActivity::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Completed A Transaction',
            ]);
        }

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }


    public function deleteMenu($orderId, $menuId)
    {
        $order = Order::findOrFail($orderId);
        $order->menus()->detach($menuId);

        $totalHarga = $order->menus->sum(function ($menu) {
            return $menu->harga * $menu->pivot->qty;
        });

        $order->update(['total' => $totalHarga]);

        return redirect()->back()->with('success', 'Menu deleted successfully!');
    }

    public function generateReceipt($id)
    {
        $order = Order::findOrFail($id);

        $html = view('pages.order.struk', compact('order'))->render();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();
        file_put_contents('order_receipt.pdf', $output);

        return response()->download('order_receipt.pdf')->deleteFileAfterSend(true);
    }
}
