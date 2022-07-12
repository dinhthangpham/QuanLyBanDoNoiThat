<table id="product" class="table">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Avatar</th>
            <th>Description</th>
            <th></th>
            <th>
                Option
            </th>
        </tr>
    </thead>
    <tbody id="listProduct">
        @foreach ($products as $product)
            <tr class='line-product'>
                <td class="product_table-id" name='product_table-id'>{{ $product->id }} </td>
                <td style="overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                  max-width:150px;" class="product_table-name"  name="product_table-name">{{ $product->name }}</td>
                <td clas="product_table-categoryName" name="product_table-categoryName">{{ $product->categoryName }}
                </td>
                <td>
                    <img name="product_table-image" style="width: 100px;height: 100px; background-size=cover;"
                        src="{{ $product->avatar }}" alt="">
                </td>
                <td
                    style="max-width:190px;
                    text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;">
                    <span class="">{!! $product->desc !!}</span></td>
                <td>
                    <input type="hidden" class="idCate" name="idCate" value="{{ $product->id }}" </td>
                <td>
                    <button class="btn btn-warning btn_product-update" idUpdate={{ $product->id }}
                        onclick="openDialogUpdate({{ $product->id }})" name="btn_product-update">Update</button>
                    <button class="btn btn-danger btn_product-delete" onclick="deleteProduct({{ $product->id }})" idDelete={{ $product->id }}
                        name="btn_product-delete">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $products->links() !!}
