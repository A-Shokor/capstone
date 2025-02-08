<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;

class PurchaseOrderItemController extends Controller
{
    /**
     * Remove the specified purchase order item.
     */
    public function destroy(PurchaseOrderItem $item)
    {
        $item->delete();

        return redirect()->back()->with('success', 'Purchase order item deleted successfully.');
    }
}
