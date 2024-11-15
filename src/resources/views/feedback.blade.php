@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
@endsection

@section('main')
<div class="contents-flex">
  <div class="shop-view">
    <h1 class="page-title">今回のご利用はいかがでしたか？</h1>
    <div class="shop-card">
      <div class="shop__img-area">
        <img class="shop__img-body" src="{{ $shop->img_url ?? '' }}" alt="
        @if($shop->img_url) {{ $shop->name ?? '' }}
        @else No Image @endif
        ">
      </div>
      <div class="shop__contents">
        <div class="shop__name">
          {{ $shop['name'] ?? '' }}
        </div>
        <div class="shop__tags">
          #{{ $shop->area->name ?? '' }}
          #{{ $shop->category->name ?? ''}}
        </div>
        <div class="form-buttons">
          <div class="form-buttons__detail">
            <form action="/shop_details" method="get">
              @csrf
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button class="common-btn" type="submit">詳しくみる</button>
            </form>
          </div>
          <div class="form-buttons__favorite">
            @if ($favorite_shop)
              <form action="/unfavorite" method="post">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                  <button class="favorite-btn--on" type="submit"></button>
              </form>
            @else
              <form action="/favorite" method="post">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <button class="favorite-btn--off" type="submit"></button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <form class="feedback-form" action="/feedback" enctype="multipart/form-data" method="post">
  @csrf
    <div class="feedback-contents">
      <input type="hidden" name="shop_id" value="{{ $shop->id }}">
      <h2 class="feedback-label">体験を評価してください</h2>
      <div class="rating-form">
        <input class="rating-form__input" id="star1" name="rating" type="radio" value="1" {{ (old('rating') ?? ($previous_feedback && $previous_feedback->rating == 1)) ? 'checked' : '' }}>
        <label class="rating-form__label" for="star1"><i class="fa-solid fa-star"></i></label>

        <input class="rating-form__input" id="star2" name="rating" type="radio" value="2" {{ (old('rating') ?? ($previous_feedback && $previous_feedback->rating == 2)) ? 'checked' : '' }}>
        <label class="rating-form__label" for="star2"><i class="fa-solid fa-star"></i></label>

        <input class="rating-form__input" id="star3" name="rating" type="radio" value="3" {{ (old('rating') ?? ($previous_feedback && $previous_feedback->rating == 3)) ? 'checked' : '' }}>
        <label class="rating-form__label" for="star3"><i class="fa-solid fa-star"></i></label>

        <input class="rating-form__input" id="star4" name="rating" type="radio" value="4" {{ (old('rating') ?? ($previous_feedback && $previous_feedback->rating == 4)) ? 'checked' : '' }}>
        <label class="rating-form__label" for="star4"><i class="fa-solid fa-star"></i></label>

        <input class="rating-form__input" id="star5" name="rating" type="radio" value="5" {{ (old('rating') ?? ($previous_feedback && $previous_feedback->rating == 5)) ? 'checked' : '' }}>
        <label class="rating-form__label" for="star5"><i class="fa-solid fa-star"></i></label>
      </div>
      <div class="feedback-form__error">
        @error('rating')
        ※ {{ $message }}
        @enderror
      </div>
      <h2 class="feedback-label">口コミを投稿</h2>
      <div class="word-count-form">
        <textarea id="comment-form" name="comment" value="{{ old('comment') }}" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('comment') ?? $previous_feedback->comment ?? '' }}</textarea>
        <div class="word-counter">
          <div class="length">0</div>
          /400（最高文字数）
        </div>
      </div>
      <div class="feedback-form__error">
        @error('comment')
        ※ {{ $message }}
        @enderror
      </div>
      <h2 class="feedback-label">画像の追加</h2>
      <div id="upload-area">
        <p class="upload-text">
          <span class="upload-text__subject">クリックして写真を追加</span>
          またはドラックアンドドロップ
        </p>
        <input id="img-input" type="file" accept="image/*" name="img">
      </div>
      <div class="feedback-form__error">
        @error('img')
        ※ {{ $message }}
        @enderror
      </div>

      @if(session('uploaded_img'))
    <p>Uploaded Image Path: {{ session('uploaded_img') }}</p>
@endif

      @if(isset($previous_feedback) && $previous_feedback->img_path)
        <h2 class="feedback-label">過去の投稿画像</h2>
        <div class="previous-img-area">
          <img class="previous-img" src="{{ $previous_feedback->img_path }}">
        </div>
        <p>※画像を新しく追加すると、過去の投稿画像は上書きされます</p>
      @endif
    </div>

    <div class="feedback-submit">
      <button type="submit" class="feedback-btn">口コミを投稿</button>
    </div>
  </form>
</div>
@endsection

@section('script')
<script type="text/javascript">

  // 字数カウンター
  const textArea = document.querySelector('#comment-form');
  const length = document.querySelector('.length');
  textArea.addEventListener('input', () => {
    length.textContent = textArea.value.length;
  }, false);

// 1MB制限
const sizeLimit = 1024 * 1024 * 1;
const fileInput = document.getElementById('img-input');

// ファイル選択時のサイズチェック
const handleFileSelect = () => {
  const files = fileInput.files;

  // 複数ファイル選択を防ぐ
  if (files.length > 1) {
    alert('1ファイルのみ選択してください');
    fileInput.value = ''; // リセット
    removeImagePreview(); // プレビューを削除
    return;
  }

  // ファイルが選択されたらサイズチェック
  const file = files[0];

  if (file.size > sizeLimit) {
    alert('ファイルサイズは1MB以下にしてください');
    fileInput.value = ''; // リセット
    removeImagePreview(); // プレビューを削除
  } else {
    imgPreview(file); // サイズが問題なければプレビュー表示
  }
};

fileInput.addEventListener('change', handleFileSelect);

// クリック時の動作
document.getElementById("upload-area").addEventListener("click", function() {
  document.getElementById("img-input").click();
});

// ドラッグ&ドロップ
const fileArea = document.getElementById('upload-area');
fileArea.addEventListener('dragover', function(evt) {
  evt.preventDefault();
  fileArea.classList.add('dragover');
});
fileArea.addEventListener('dragleave', function(evt) {
  evt.preventDefault();
  fileArea.classList.remove('dragover');
});
fileArea.addEventListener('drop', function(evt) {
  evt.preventDefault();
  fileArea.classList.remove('dragover');
  const files = evt.dataTransfer.files;
  fileInput.files = files;
  handleFileSelect(); // ドロップ後にサイズチェック
});

// ファイル選択時にプレビューを表示するイベントリスナー
document.getElementById("img-input").addEventListener("change", function(event) {
    // ここでファイルが選択されていることを確認
    const files = event.target.files;

    if (files && files.length > 0) {
        imgPreview(files[0]); // 最初のファイルを渡してプレビューを表示
    } else {
        console.error("ファイルが選択されていません。");
    }
});

// プレビュー表示関数
function imgPreview(file) {
    removeImagePreview(); // 既存のプレビューを削除

    if (file) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById("upload-area");
            const img = document.createElement("img");
            img.setAttribute("src", reader.result);
            img.setAttribute("id", "previewImage");
            img.classList.add("preview-img");
            preview.appendChild(img); // プレビューエリアに画像を追加
        };
        reader.readAsDataURL(file); // ファイルを読み込んでプレビュー表示
    }
}

// 既存のプレビューを削除する関数
function removeImagePreview() {
    const existingImage = document.getElementById("previewImage");
    if (existingImage) {
        existingImage.remove(); // 既存のプレビュー画像を削除
    }
}


// バリデーションエラー後でもプレビューを保持する処理
window.addEventListener('load', function() {
    const oldFilePath = '{{ session('uploaded_img') }}';
    console.log('Old File Path:', oldFilePath); // デバッグ用

    if (oldFilePath) {
        const preview = document.getElementById("upload-area");
        const img = document.createElement("img");
        img.setAttribute("src", oldFilePath); // 画像パスを設定
        img.setAttribute("id", "previewImage");
        img.classList.add("preview-img");
        preview.appendChild(img);
    }
});

</script>
@endsection