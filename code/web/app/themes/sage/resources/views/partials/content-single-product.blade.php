<article @php post_class() @endphp>
  <header>
    <h1 class="entry-title"> {{$product_name}}</h1>
  </header>
  <div class="entry-content">
    @if($images)
      <div class="owl-carousel owl-theme">
      @foreach($images as $image)
          <div><img src="{{$image}}"></div>
      @endforeach
      </div>
    {{$product_type}}
    @endif
    {{$original_product_name}}
    {!!$product_price!!}
    {{$product_package}}
    {{$product_size}}
    {{$product_period}}
    {{$product_light}}
    {{$product_water}}
    {!!$product_other_info!!}
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
