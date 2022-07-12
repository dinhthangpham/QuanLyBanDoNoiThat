<table id="slider" class="table">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Name Slider</th>
            <th>Url</th>
            <th>Image</th>
            <th>Active</th>
            <th></th>
            <th>
                Option
            </th>
        </tr>
    </thead>
    <tbody id="listSlider">
        @foreach ($sliders as $slider)
            <tr class='line-slider'>
                <td class="slider-id" name='slider_table-id'>{{ $slider->id }} </td>
                <td clas="slider_table-name" name="slider_table-name">{{ $slider->name_slider }}</td>
                <td clas="slider_table-url" name="slider_table-url">{{ $slider->url }}</td>
                <td>
                    <img name="slider_table-image" style="width: 180px;height: 100px; background-size=cover;"
                        src="{{ $slider->image }}" alt="">
                </td>
                <td
                    style="max-width:190px;
                      text-overflow: ellipsis;
                      white-space: nowrap;
                      overflow: hidden;">
                    <span class="">{{ $slider->active == 0 ? 'No' : 'Yes' }}</span></td>
                <td>
                    <input type="hidden" class="idCate" name="idCate" value="{{ $slider->id }}" </td>
                <td>
                    <button class="btn btn-warning btn_product-update" idUpdate={{ $slider->id }}
                        onclick="openDiaLogUpdate({{ $slider->id }})" name="btn_product-update">Update</button>
                    <button class="btn btn-danger btn_product-delete" idDelete={{ $slider->id }}
                        onclick="deleteSlider({{ $slider->id }})"
                        name="btn_product-delete">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $sliders->links() !!}
