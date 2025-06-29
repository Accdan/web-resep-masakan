<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use App\Models\MenuTag;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->orderBy('created_at', 'desc')->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.menu.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_menu' => 'required|string',
            'prosedur' => 'required|string',
            'is_premium' => 'required|boolean',
            'gambar_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'video_url' => 'nullable|string',
        ]);

        $data = $request->only(['nama_menu', 'deskripsi_menu', 'prosedur', 'kategori_id', 'is_premium']);
        $data['video_url'] = $request->video_url;

        if ($request->hasFile('gambar_menu')) {
            $file = $request->file('gambar_menu');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menu'), $filename);
            $data['gambar_menu'] = $filename;
        }

        $menu = new Menu($data);
        $menu->id = (string) \Illuminate\Support\Str::uuid();
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.menu.edit', compact('menu', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_menu' => 'required|string',
            'prosedur' => 'required|string',
            'is_premium' => 'required|boolean',
            'gambar_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'video_url' => 'nullable|string',
        ]);

        $menu->nama_menu = $request->nama_menu;
        $menu->kategori_id = $request->kategori_id;
        $menu->deskripsi_menu = $request->deskripsi_menu;
        $menu->prosedur = $request->prosedur;
        $menu->is_premium = $request->is_premium;
        $menu->video_url = $request->video_url;

        if ($request->hasFile('gambar_menu')) {
            if ($menu->gambar_menu && file_exists(public_path('uploads/menu/' . $menu->gambar_menu))) {
                unlink(public_path('uploads/menu/' . $menu->gambar_menu));
            }

            $file = $request->file('gambar_menu');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menu'), $filename);
            $menu->gambar_menu = $filename;
        }

        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }


    public function show($id)
    {
        $menu = Menu::with(['kategori', 'ingredients'])->findOrFail($id);
        return view('admin.menu.show', compact('menu'));
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->deleteMenu();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function attachTag(Request $request, $menuId)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        MenuTag::attachTagToMenu($menuId, $request->tag_id);

        return back()->with('success', 'Tag berhasil ditambahkan ke menu.');
    }

    public function detachTag($menuId, $tagId)
    {
        MenuTag::detachTagFromMenu($menuId, $tagId);

        return back()->with('success', 'Tag berhasil dihapus dari menu.');
    }

    public function detail($id)
    {
        $menu = Menu::findOrFail($id);
        return view('user.detail-menu', compact('menu'));
    }
}
