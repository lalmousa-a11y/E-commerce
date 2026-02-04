<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Http\Requests\UpdateSellerRequest;



class SellerController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = User::where('user_type', 'seller')->with('seller');

    //     if ($request->has('search') && $request->search) {
    //         $search = $request->search;
    //         $query->where(function($q) use ($search) {
    //             $q->where('name', 'LIKE', "%{$search}%")
    //               ->orWhere('email', 'LIKE', "%{$search}%");
    //         });
    //     }

    //     if ($request->has('is_approved') && $request->is_approved !== '') {
    //         $query->whereHas('seller', function($q) use ($request) {
    //             $q->where('is_approved', $request->is_approved);
    //         });
            
    //     $sellers = $query->latest()
    //         ->paginate(20)
    //         ->appends($request->query());

    //     return view('admin.sellers.index', compact('sellers'));
    // }
    //     }
public function index(Request $request)
{
     $query = Seller::with(['user', 'products']); 

    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    if ($request->has('is_approved') && $request->is_approved !== '') {
        $query->where('is_approved', $request->is_approved);
    }

    $sellers = $query->latest()->paginate(20)->appends($request->query());
           $stats = [
            'total_sellers' => Seller::count(),
            'approved_sellers' => Seller::where('is_approved', true)->count(),
            'pending_sellers' => Seller::where('is_approved', false)->count(),
        ];
    $sellers->getCollection()->transform(function($seller) {
    $seller->stats = [
        'total_products' => $seller->products->count(),
        'approved_products' => $seller->products->where('status', 'approved')->count(),
        'pending_products' => $seller->products->where('status', 'pending')->count(),
        'rejected_products' => $seller->products->where('status', 'rejected')->count(),
    ];
    return $seller;
});
    return view('admin.sellers.index', compact('sellers','stats'));
}

    public function show(Seller $seller)
    {
        if ($seller->user_type !== 'seller') {
            return redirect()->route('admin.sellers.index')
                ->with('error', ' user is not a seller');
        }

        $seller->load(['user', 'products']);

        $stats = [
            'total_products' => $seller->products->count(),
            'approved_products' => $seller->products->where('status', 'approved')->count(),
            'pending_products' => $seller->products->where('status', 'pending')->count(),
            'rejected_products' => $seller->products->where('status', 'rejected')->count(),
        ];

        return view('admin.sellers.show', compact('seller', 'stats'));
    }


    public function approve(Seller $seller)
    {
        if ($seller->user_type !== 'seller') {
            return back()->with('error', ' invalid data');
        }

        $seller->seller->update(['is_approved' => true]);

        return back()->with('success', ' seller approved successfully ');
    }
   
public function edit(Seller $seller)
{
    $seller->load('user');
    return view('admin.sellers.edit', compact('seller'));
}

public function update(UpdateSellerRequest $request, Seller $seller)
{
  
    
    $seller->user->update([
        'name' => $request['name'],]);
    
    $seller->update([
        'is_approved' => $request['is_approved'],
    ]);
    
    return redirect()->route('admin.sellers.index')
        ->with('success', 'Seller updated successfully');
}
    public function reject(User $seller)
    {
        if ($seller->user_type !== 'seller') {
            return back()->with('error', 'invalid data');
        }

        $seller->seller->update(['is_approved' => false]);

        return back()->with('success', ' seller rejected successfully');
    }

    public function destroy(User $seller)
    {
        if ($seller->user_type !== 'seller') {
            return back()->with('error', ' invalid data');
        }

        $seller->products()->delete();

        $seller->seller()->delete();

        $seller->delete();

        return redirect()->route('admin.sellers.index')
            ->with('success', 'seller and all products deleted successfully');
    }
}