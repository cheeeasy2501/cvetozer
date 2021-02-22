@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  {!! $current_catalog_categories !!}

  @while (have_posts()) @php the_post() @endphp
  @endwhile


@endsection
