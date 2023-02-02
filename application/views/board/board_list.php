<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- csrf token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Board Exam</title>
  <!-- fontawsome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- jquery -->
  <script src="/ci/js/jquery-3.6.3.min.js" type="text/javascript"></script>
  <script src="/ci/js/jquery.bpopup.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    /* $.ajax({
      type: 'POST', 
      url: '/index.php/board/write', 
      data: {}, // 전송할 데이터
      cache: false,
      async: false
    }).done(function (html) {

    }); */
    // bPopup
    function openMessage(IDS) {
      $('#' + IDS).bPopup();
      // $('#writeBody').bPopup();
    }
    function addBoard() {
      openMessage('writeBody')
    }
    function execSave() {
      if (!$("#name").val()) {
        alert("이름을 입력하세요");
        $("#name").focus();
        return false;
      }
      if (!$("#title").val()) {
        alert("제목을 입력하세요");
        $("#title").focus();
        return false;
      }
      if (!$("#contents").val()) {
        alert("내용을 입력하세요");
        $("#contents").focus();
        return false;
      }
      $.ajax({
        type: 'POST',
        url: '/index.php/board/write_ok',
        data: { name: $("#name").val(), title: $("#title").val(), contents: $("#contents").val() }, // 전송할 데이터
        cache: false,
        async: false //이 기능이 전부 실행 되어야 다음 단계로 넘어가 의도하지 않은 에러 방지
      })
        .done(function (html) {
          alert("성공적으로 저장 되었습니다");
        });
    }
  </script>
</head>

<body>
  <!-- bootstrap list -->
  <div class="list-group mt-5 container">
    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
      The current link item
    </a>
    <a href="#" class="list-group-item list-group-item-action">A second link item</a>
    <a href="#" class="list-group-item list-group-item-action">A third link item</a>
    <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
    <a class="list-group-item list-group-item-action disabled">A disabled link item</a>
  </div>
  <!-- bootstrap button -->
  <div class="d-grid gap-2 d-md-flex justify-content-md-end container mt-3">
    <!-- <button class="btn btn-primary me-md-2" type="button">Button</button> -->
    <button class="btn btn-primary" type="button" onclick="addBoard()">글쓰기</button>
  </div>

  <!-- 글쓰기 팝업 -->
  <!-- style="display: none; width: 80%; height: 30rem; background-color: white;" -->
  <div class="container p-5" id="writeBody" style="display: none; width: 80%; height: 40rem; background-color: white;">
    <div class="row my-3">
      <div class="col-12">
        <label>이름</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>
    </div>
    <!-- category select option  -->
    <div class="row my-3">
      <div class="col-12">
        <label>제목</label>
        <input type="text" class="form-control" name="title" id="title">
      </div>
    </div>
    <!-- contents -->
    <div class="row mt-3">
      <div class="col-12">
        <label for="floatingTextarea2">내용</label>
        <textarea class="form-control" placeholder="Leave a comment here" id="contents" name="contents"
          style="height: 200px"></textarea>
      </div>
    </div>
    <!-- 포스팅만들기 전송  -->
    <div class="row mt-2">
      <div class="col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button class="btn btn-success" type="button" id="submit" onclick="execSave()">저장</button>
        </div>
      </div>
    </div>
  </div>


</body>

</html>