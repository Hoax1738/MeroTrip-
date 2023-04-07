@extends('layouts.frontend.app')
@section('title') {{__($imageitems['title']).'- Tripkhata®'}} @endsection
@section('content')

<style>
    .btn:focus, .btn:active, button:focus, button:active {
  outline: none !important;
  box-shadow: none !important;
}

#image-gallery .modal-footer{
  display: block;
}

.thumb{
  margin-top: 15px;
  margin-bottom: 15px;
}
</style>

<section class="content">
    <section id="gallery" class="ftco-section img ftco-select-destination">
        <div class="container">
                @if (Auth::check())
                @include('contents.emiAlert')
                @else
                @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">{{__($imageitems['title'])}}</span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="row">
                    <?php $images= explode(",",$imageitems['images']);?>   
                    @foreach($images as $key=>$image)
                      @php $img=\App\Image::find($image);@endphp
                      @if(count($images)>1)
                        <div class="@if(count($images)==2)col-lg-6 @elseif(count($images)>2) col-lg-4 @endif col-md-4 col-xs-6 thumb">
                            <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="{{__($imageitems['title'])}}"
                            @if($img->drive_id==NULL) data-image="{{ url("$img->directory/$img->local_filename") }}" @else data-image="https://drive.google.com/uc?export=view&id={{$img->drive_id}}" @endif
                              data-target="#image-gallery">
                                <img style="height: 300px; width:550px" class="img-fluid" @if($img->drive_id==NULL) src="{{ url("$img->directory/$img->local_filename") }}" @else src="https://drive.google.com/uc?export=view&id={{$img->drive_id}}" @endif
                                    alt="Another alt text">
                            </a>
                        </div>
                      @else
                        <div class="mx-auto d-block col-md-6">
                            <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="{{__($imageitems['title'])}}"
                            @if($img->drive_id==NULL) data-image="{{ url("$img->directory/$img->local_filename") }}" @else data-image="https://drive.google.com/uc?export=view&id={{$img->drive_id}}" @endif
                            data-target="#image-gallery">
                              <img class="img-thumbnail" @if($img->drive_id==NULL) src="{{ url("$img->directory/$img->local_filename") }}" @else src="https://drive.google.com/uc?export=view&id={{$img->drive_id}}" @endif
                                  alt="Another alt text">
                            </a>
                        </div> 
                      @endif  
                    @endforeach
                </div>

                <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="image-gallery-title"></h4>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                            </div>
                            <div class="modal-footer">
                                @if(count($images)>1)
                                  <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                                  </button>
                                  <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                                  </button>
                                @endif  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<script>
    let modalId = $('#image-gallery');

$(document)
  .ready(function () {

    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current) {
      $('#show-previous-image, #show-next-image')
        .show();
      if (counter_max === counter_current) {
        $('#show-next-image')
          .hide();
      } else if (counter_current === 1) {
        $('#show-previous-image')
          .hide();
      }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr) {
      let current_image,
        selector,
        counter = 0;

      $('#show-next-image, #show-previous-image')
        .click(function () {
          if ($(this)
            .attr('id') === 'show-previous-image') {
            current_image--;
          } else {
            current_image++;
          }

          selector = $('[data-image-id="' + current_image + '"]');
          updateGallery(selector);
        });

      function updateGallery(selector) {
        let $sel = selector;
        current_image = $sel.data('image-id');
        $('#image-gallery-title')
          .text($sel.data('title'));
        $('#image-gallery-image')
          .attr('src', $sel.data('image'));
        disableButtons(counter, $sel.data('image-id'));
      }

      if (setIDs == true) {
        $('[data-image-id]')
          .each(function () {
            counter++;
            $(this)
              .attr('data-image-id', counter);
          });
      }
      $(setClickAttr)
        .on('click', function () {
          updateGallery($(this));
        });
    }
  });

// build key actions
$(document)
  .keydown(function (e) {
    switch (e.which) {
      case 37: // left
        if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
          $('#show-previous-image')
            .click();
        }
        break;

      case 39: // right
        if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
          $('#show-next-image')
            .click();
        }
        break;

      default:
        return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
  });
</script>

@endsection
