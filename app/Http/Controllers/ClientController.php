<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by app
        if ($request->filled('app')) {
            $query->where('app', $request->app);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('shop_id', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.client.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'country' => 'nullable|string|max:2',
            'shop_id' => 'nullable|string|max:255',
            'app' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        Client::create($request->all());

        return redirect('/admin/client')->with('berhasil', 'Client berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.client.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'country' => 'nullable|string|max:2',
            'shop_id' => 'nullable|string|max:255',
            'app' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $client->update($request->all());

        return redirect('/admin/client')->with('berhasil', 'Client berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect('/admin/client')->with('berhasil', 'Client berhasil dihapus.');
    }
}
