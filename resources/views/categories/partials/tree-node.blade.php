<li>
    <div class="category-tree-node d-flex align-items-center" data-category-id="{{ $node['id'] }}">
        <div class="category-tree-icon {{ $node['category_type'] }}">
            @if(isset($node['children']) && count($node['children']) > 0)
                <span class="category-tree-toggle collapsed" data-toggle="collapse" data-target="#cat-{{ $node['id'] }}">
                    <i class="fa fa-angle-left"></i>
                </span>
            @else
                <span class="category-tree-toggle invisible"></span>
            @endif
        </div>
        <div>
            <span class="category-tree-name">{{ $node['name'] }}</span>
            <span class="badge badge-secondary category-tree-type">{{ categoryTypeFa($node['category_type']) }}</span>
            @if($node['code'])
                <span class="badge badge-light category-tree-code">{{ $node['code'] }}</span>
            @endif
        </div>
    </div>
    @if(isset($node['children']) && count($node['children']) > 0)
        <ul class="category-tree-children collapse" id="cat-{{ $node['id'] }}">
            @foreach($node['children'] as $child)
                @include('categories.partials.tree-node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
