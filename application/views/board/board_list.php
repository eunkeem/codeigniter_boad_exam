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
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="/ci/js/jquery.bpopup.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    // 글쓰기 초기화
    function board_init() {
      $("#name").val("");
      $("#title").val("");
      $("#contents").val("");

      $('#writeBody').bPopup().close();
      $('#viewBody').bPopup().close();
    }
    // 문서가 모두 로드되면
    $(document).ready(function () {
      loadinglist()
    });
    // 데이터 불러오기
    function loadinglist() {
      $.ajax({
        type: 'POST',
        url: "board/getList",
        data: { PAGE: '1' },
        cache: false,
        async: false
      })
        .done(function (html) {
          $("#tableBody").html(html);
        });
    }
    // bPopup
    function openMessage(IDS) {
      $('#' + IDS).bPopup();
      // $('#writeBody').bPopup();
    }
    // 글쓰기 버튼 클릭 이벤트
    function addBoard() {
      openMessage('writeBody')
    }
    // 제목 클릭 이벤트
    function viewBoard(CODE) {
      $.ajax({
        type: 'POST',
        url: "board/getView",
        data: { CODE: CODE },
        cache: false,
        async: false
      })
        .done(function (html) {
          let html_array = html.split("^");
          if (html_array.length == 5) {
            let name = html_array[0];
            let title = html_array[1];
            let contents = html_array[2];
            let adddate = html_array[3];
            let code = html_array[4];

            $('#name_view').val(name);
            $('#title_view').val(title);
            $('#contents_view').val(contents);
            $('#adddate_view').val(adddate);
            $('#code_view').val(code);
          } else {
            alert("Error");
          }
        });
      openMessage('viewBody')
    }
    // 작성한 내용 저장
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
      let name = $("#name").val();
      let title = $("#title").val();
      let contents = $("#contents").val();

      $.ajax({
        type: 'POST',
        url: 'board/write_ok',
        data: { name: name, title: title, contents: contents }, // 전송할 데이터
        cache: false,
        async: false //이 기능이 전부 실행 되어야 다음 단계로 넘어가 의도하지 않은 에러 방지
      })
        .done(function (html) {
          if (html == "1") {
            alert("성공적으로 저장 되었습니다");
            board_init(); //입력창 초기화
            loadinglist(); //방금 저장한것까지 리스트 업데이트
          } else {
            alert("Error:" + html);
          }
        });
    }
    // 수정한 내용 저장
    function execUpdate() {
      if (!$("#title_view").val()) {
        alert("제목을 입력하세요");
        $("#title").focus();
        return false;
      }
      if (!$("#contents_view").val()) {
        alert("내용을 입력하세요");
        $("#contents").focus();
        return false;
      }
      let title = $("#title_view").val();
      let contents = $("#contents_view").val();
      let code = $("#code_view").val();

      $.ajax({
        type: 'POST',
        url: 'board/update',
        data: { title: title, contents: contents, code: code }, // 전송할 데이터
        cache: false,
        async: false //이 기능이 전부 실행 되어야 다음 단계로 넘어가 의도하지 않은 에러 방지
      })
        .done(function (html) {
          if (html == "1") {
            alert("성공적으로 수정 되었습니다");
            board_init(); //입력창 초기화
            loadinglist(); //방금 저장한것까지 리스트 업데이트
          } else {
            alert("Error:" + html);
          }
        });
    }
    function execDelete() {
      if (confirm("해당 게시물을 삭제하시겠습니까?") == true) {
        let code = $("#code_view").val();

        $.ajax({
          type: 'POST',
          url: 'board/delete',
          data: { code: code }, // 전송할 데이터
          cache: false,
          async: false //이 기능이 전부 실행 되어야 다음 단계로 넘어가 의도하지 않은 에러 방지
        })
          .done(function (html) {
            if (html == "1") {
              alert("성공적으로 삭제 되었습니다");
              board_init(); //입력창 초기화
              loadinglist(); //방금 저장한것까지 리스트 업데이트
            } else {
              alert("Error:" + html);
            }
          });
      } else {
        board_init(); //입력창 초기화
        loadinglist(); //방금 저장한것까지 리스트 업데이트
      }

    }
  </script>
</head>

<body>
  <hr>
  <div id="tableBody">
    <!-- 데이터베이스에서 가져온 데이터를 테이블로 보여줌 -->
  </div>
  <!-- 페이지네이션 -->
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
  <!-- bootstrap button -->
  <div class="d-grid gap-2 d-md-flex justify-content-md-end container mt-3">
    <button class="btn btn-primary" type="button" onclick="addBoard()">글쓰기</button>
  </div>

  <!-- 글쓰기 팝업 -->
  <!-- style="display: none; width: 80%; height: 30rem; background-color: white;" -->
  <div class="container p-5" id="writeBody" style="display: none; width: 80%; height: 40rem; background-color: white;">
    <div class="row my-3">
      <div class="col-12">
        <label>이름</label>
        <input type="text" class="form-control border border-secondary" name="name" id="name">
      </div>
    </div>
    <!-- category select option  -->
    <div class="row my-3">
      <div class="col-12">
        <label>제목</label>
        <input type="text" class="form-control border border-secondary" name="title" id="title">
      </div>
    </div>
    <!-- contents -->
    <div class="row mt-3">
      <div class="col-12">
        <label for="floatingTextarea2">내용</label>
        <textarea class="form-control border border-secondary" placeholder="Leave a comment here" id="contents"
          name="contents" style="height: 200px"></textarea>
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

  <!-- 상세보기 팝업 -->
  <div class="container p-5" id="viewBody" style="display: none; width: 80%; height: 40rem; background-color: white;">
    <input type="hidden" name="code_view" id="code_view">
    <div class="row my-3">
      <div class="col-12">
        <label>이름</label>
        <input type="text" class="form-control" name="name_view" id="name_view" readonly>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-12">
        <label>작성일</label>
        <input type="text" class="form-control" name="adddate_view" id="adddate_view" readonly>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-12">
        <label>제목</label>
        <input type="text" class="form-control" name="title_view" id="title_view">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12">
        <label for="floatingTextarea2">내용</label>
        <textarea class="form-control" placeholder="Leave a comment here" id="contents_view" name="contents_view"
          style="height: 200px"></textarea>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button class="btn btn-primary me-md-2" type="button" id="update" onclick="execUpdate()">수정하기</button>
          <button class="btn btn-success" type="button" id="delete" onclick="execDelete()">삭제하기</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>