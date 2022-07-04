<table id="category" class="table">
    <thead class="table-success">
        <tr>
            <th >ID</th>
                <th>Name</th>
                <th>Image</th>
                <th >Description</th>
                <th></th>
                <th>
                  Option
                </th>
              </tr>
            </thead>
        
            <tbody id="listCategory">
                @foreach ($list as $category)
        <tr class='line-category-{{ $loop->index }}'>
            <td class="category_table-id" name='category_table-id'>{{ $category->id }} </td>
            <td clas="category_table-name" name="category_table-name">{{ $category->name }}</td>
            <td>
                <img name="category_table-image" style="width: 100px;height: 100px; background-size=cover;" src="{{ $category->image }}"
                    alt="">
            </td>
            <td style="max-width:190px;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;"><span class="">{{ $category->desc }}</span></td>
            <td>
                <input type="hidden" class="idCate" name="idCate" value="{{ $category->id }}" </td>
            <td>
                <button class="btn btn-warning btn_category-update" onclick="updateCategory({{ $category->id }},{{ $loop->index }})" name="btn_category-update">Update</button>
                <button class="btn btn-danger btn_category-delete" onclick="deleteCategory({{ $category->id }},{{ $loop->index }})" name="btn_category-delete">Delete</button>
            </td>
        </tr>
    
        @endforeach
        </tbody>
</table>
{!! $list->links() !!}
