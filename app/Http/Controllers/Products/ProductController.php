<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        // Retrieve products with associated points and users
        $products = Product::with(['point.endereco', 'user'])->paginate(10);
    
        // Return the view with products
        return view('profile.manager.manager-products', compact('products'));
    }
    public function loadUserPointsForDropdown()
    {
    return Point::where('user_id', auth()->id())->get();
    }

    
    /**
     * Exibe um produto específico.
     */
    public function show($id)
    {
        $product = Product::with(['point.endereco', 'user'])->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Cria um novo produto.
     */
    public function store(Request $request)
    {
        // Valida os dados dos produtos
        $validatedData = $request->validate([
            'products.*.name' => 'required|string|max:255',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'products.*.description' => 'nullable|string',
            'products.*.image' => 'nullable|image|max:2048',
            'products.*.ponto_id_fk' => 'required|exists:points,id', // Validação do ponto
        ]);
    
        foreach ($request->products as $productData) {
            if (isset($productData['image'])) {
                $imagePath = $productData['image']->store('products', 'public');
                $productData['image'] = $imagePath;
            }
    
            // Adiciona a chave estrangeira user_id e ponto_id_fk
            $productData['user_id'] = auth()->id();
    
            Product::create($productData);
        }
    
        return redirect()->route('profile.manager.products')
            ->with('success', 'Produtos cadastrados com sucesso!');
    }    

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Adjust to accept image files
        ]);
    
        $product = Product::findOrFail($id);
    
        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }
    
        $product->update($validatedData);
    
        return redirect()->route('profile.manager.products')
            ->with('success', 'Produto atualizado com sucesso!');
    }
    
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
    
        // Carrega os pontos do usuário logado para o dropdown
        $points = Point::where('user_id', auth()->id())->get();
    
        return view('profile.products.edit-product', compact('product', 'points'));
    }
    

    /**
     * Remove um produto específico.
     */
    public function destroy(Product $product)
    {
        // Verifica se o usuário autenticado é o proprietário do produto
        $this->authorize('delete', $product);
    
        // Exclui o produto
        $product->delete();
    
        // Redireciona para a lista de produtos com uma mensagem de sucesso
        return redirect()->route('profile.manager.products')->with('success', 'Produto excluído com sucesso!');
    }
    
    public function create($point_id)
    {
        return view('products.create', ['point_id' => $point_id]);
    }
}
