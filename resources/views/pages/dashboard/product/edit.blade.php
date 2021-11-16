<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; {{ $product->name }} &raquo; Edit
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if ($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong!
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </p>
                        </div>
                    </div>
                @endif
                <form action="{{ route('dashboard.product.update', $product->id) }}" class="w-full"
                    enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="name"
                                class="block uppercase tracing-wide text-gray-700 text-xs font-bold mb-2">Name</label>
                            <input placeholder="Product Name" type="text" name="name" id=""
                                value="{{ old('name') ?? $product->name }}"
                                class="block w-full bg-gray-100 text-gray-800 border border-gray-300 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-600">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="description"
                                class="block uppercase tracing-wide text-gray-700 text-xs font-bold mb-2">Description</label>
                            <textarea name="description" id=""
                                class="block w-full bg-gray-200 text-gray-800 border border-gray-300 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-600">{!! old('description') ?? $product->description !!}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="price"
                                class="block uppercase tracing-wide text-gray-700 text-xs font-bold mb-2">Price</label>
                            <input placeholder="Product Price" type="number" name="price" id=""
                                value="{{ old('price') ?? $product->price }}"
                                class="block w-full bg-gray-100 text-gray-800 border border-gray-300 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-600">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <button type="submit"
                                class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-lg mr-2">Update
                                Product</button>
                            <a href="{{ route('dashboard.product.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow-lg">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
</x-app-layout>
