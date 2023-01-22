<!-- section news -->
<section class="mb-4">
    <div class="section padding_layout_1 py-5">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <div class="main_heading text_align_right">
                            <h3>خبر کوتاه</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($repo->posts() as $post)
                    <div class="col-md-4 rtl text_align_right">
                        <div class="full blog_colum">
                            <div class="blog_feature_img">
                                <img src="{{ $post->imagePath() }}" alt="#"/></div>
                            <div class="post_time">
                                <p>{{ jalaliDate($post->created_at) }} <i class="fa fa-clock"></i></p>
                            </div>
                            <div class="blog_feature_head">
                                <h4>{{ $post->title }}</h4>
                            </div>
                            <div class="blog_feature_cantant">
                                <p>{!! \Illuminate\Support\Str::limit($post->summary, 200) !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- end section -->
