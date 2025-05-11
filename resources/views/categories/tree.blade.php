<ul>
    @foreach($categories as $category)
        <li>
            <span class="category-item">
                <i class="fa fa-folder"></i>
                <span>{{ $category->name }}</span>
                <span class="category-code">{{ $category->code }}</span>
                <span class="category-type-badge badge-{{ $category->category_type }}">
                    @if($category->category_type == 'person') اشخاص
                    @elseif($category->category_type == 'product') کالا
                    @elseif($category->category_type == 'service') خدمات
                    @endif
                </span>
            </span>
            @if(count($category->children))
                @include('categories.tree', ['categories' => $category->children])
            @endif
        </li>
    @endforeach
</ul>
