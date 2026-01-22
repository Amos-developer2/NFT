<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NftController extends Controller
{
    /**
     * Display a listing of NFTs.
     */
    public function index(Request $request)
    {
        $query = Nft::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Filter by rarity
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        // Filter by owner
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $nfts = $query->latest()->paginate(15);
        $users = User::select('id', 'name')->get();

        return view('admin.nfts.index', compact('nfts', 'users'));
    }

    /**
     * Show the form for creating a new NFT.
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();
        return view('admin.nfts.create', compact('users'));
    }

    /**
     * Store a newly created NFT.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'background' => 'nullable|string|max:255',
            'value' => 'required|numeric|min:0',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'user_id' => 'nullable|exists:users,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('nfts', 'public');
        }

        Nft::create($validated);

        return redirect()->route('admin.nfts.index')
            ->with('success', 'NFT created successfully.');
    }

    /**
     * Display the specified NFT.
     */
    public function show(Nft $nft)
    {
        $nft->load(['user', 'auctions.bids']);
        return view('admin.nfts.show', compact('nft'));
    }

    /**
     * Show the form for editing the specified NFT.
     */
    public function edit(Nft $nft)
    {
        $users = User::select('id', 'name')->get();
        return view('admin.nfts.edit', compact('nft', 'users'));
    }

    /**
     * Update the specified NFT.
     */
    public function update(Request $request, Nft $nft)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'background' => 'nullable|string|max:255',
            'value' => 'required|numeric|min:0',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'user_id' => 'nullable|exists:users,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($nft->image && Storage::disk('public')->exists($nft->image)) {
                Storage::disk('public')->delete($nft->image);
            }
            $validated['image'] = $request->file('image')->store('nfts', 'public');
        }

        $nft->update($validated);

        return redirect()->route('admin.nfts.index')
            ->with('success', 'NFT updated successfully.');
    }

    /**
     * Remove the specified NFT.
     */
    public function destroy(Nft $nft)
    {
        // Delete image
        if ($nft->image && Storage::disk('public')->exists($nft->image)) {
            Storage::disk('public')->delete($nft->image);
        }

        $nft->delete();

        return redirect()->route('admin.nfts.index')
            ->with('success', 'NFT deleted successfully.');
    }

    /**
     * Transfer NFT to another user.
     */
    public function transfer(Request $request, Nft $nft)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $nft->update(['user_id' => $validated['user_id']]);

        return redirect()->back()
            ->with('success', 'NFT transferred successfully.');
    }
}
