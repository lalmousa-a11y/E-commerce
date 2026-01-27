<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('user_type', 'seller')->with('seller');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('is_approved') && $request->is_approved !== '') {
            $query->whereHas('seller', function($q) use ($request) {
                $q->where('is_approved', $request->is_approved);
            });
            
        $sellers = $query->latest()
            ->paginate(20)
            ->appends($request->query());

        return view('admin.sellers.index', compact('sellers'));
    }
        }


    public function show(User $seller)
    {
        if ($seller->user_type !== 'seller') {
            return redirect()->route('sellers.index')
                ->with('error', ' user is not a seller');
        }

        $seller->load(['seller', 'products']);

        $stats = [
            'total_products' => $seller->products->count(),
            'approved_products' => $seller->products->where('status', 'approved')->count(),
            'pending_products' => $seller->products->where('status', 'pending')->count(),
            'rejected_products' => $seller->products->where('status', 'rejected')->count(),
        ];

        return view('admin.sellers.show', compact('seller', 'stats'));
    }


    public function approve(User $seller)
    {
        if ($seller->user_type !== 'seller') {
            return back()->with('error', ' invalid data');
        }

        $seller->seller->update(['is_approved' => true]);

        return back()->with('success', ' seller approved successfully ');
    }
   
public function edit(User $seller)
{
    $seller->load('seller');
    return view('admin.sellers.edit', compact('seller'));
}

public function update(Request $request, User $seller)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $seller->id,
        'is_approved' => 'required|boolean',
    ]);
    
    $seller->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);
    
    $seller->seller->update([
        'is_approved' => $validated['is_approved'],
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

        return redirect()->route('sellers.index')
            ->with('success', 'seller and all products deleted successfully');
    }
}