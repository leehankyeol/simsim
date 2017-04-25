<?php
  require_once 'data.php';
  require_once 'MysqliDb.php';

  $name = $_GET['name'];
  $choiceIds = $_GET['choice-ids'];

  if ($choiceIds !== null) {
    $choiceIds = explode(',', $choiceIds);
  }

  $db = new MysqliDb(array(
    
  ));
  $db->where('id', 2);
  $count = $db->getOne('simsim_counts');
?>

<html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="심심철학관">
    <meta property="og:description" content="내 눈을 바라봐 넌 심상정 찍고">
    <meta property="og:image" content="http://minsim.or.kr/simsim/assets/images/title.png">
    <meta property="og:url" content="http://minsim.or.kr/simsim">
    <meta name="twitter:card" content="summary_large_image">

    <title>심심철학관</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <link href="./assets/style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./favicon.ico">
  </head>

  <body>
    <div class="nav-background">

    </div>
    <div class="container">
      <div class="nav">
        <a href="/simsim">
          <img class="logo" src="./assets/images/logo.png"/>
        </a>
      </div>

      <div class="content">

        <?php
          if ($name === null) {
            shuffle($choices);
        ?>

        <ul class="choices">
          <?php
            foreach ($choices as $index => $choice) {
              if ($index < 6) {
                $class = '';
                if ($index % 3 === 0) {
                  $class = 'left';
                } else if ($index % 3 === 2) {
                  $class = 'right';
                }
          ?>
          <li class="choice <?php echo $class; ?>"
            data-id="<?php echo $choice['id']; ?>">
            <img src="<?php echo $choice['image']; ?>"/>
            <div class="overlay">
              <span>선택</span>
            </div>
            <div class="caption"><?php echo $choice['caption']; ?></div>
          </li>
          <?php
              }
            }
          ?>
        </ul>

        <h2 class="title">당신은 어떤 심상정인가요?</h2>
        <div class="subtitle">(중복 선택 가능)</div>

        <ul class="choices">
          <?php
            foreach ($choices as $index => $choice) {
              if ($index >= 6) {
                $class = '';
                if ($index % 3 === 0) {
                  $class = 'left';
                } else if ($index % 3 === 2) {
                  $class = 'right';
                }
          ?>
          <li class="choice <?php echo $class; ?>"
            data-id="<?php echo $choice['id']; ?>">
            <img src="<?php echo $choice['image']; ?>"/>
            <div class="overlay">
              <span>선택</span>
            </div>
            <div class="caption"><?php echo $choice['caption']; ?></div>
          </li>
          <?php
              }
            }
          ?>
        </ul>

        <form id="form">

          <div class="label-wrapper">
            <input type="text" id="name" name="name" placeholder="이름" />
          </div>

          <button type="submit">심상정책 확인하기</button>
        </form>

        <div class="counter">
          <?php
          ?>
          현재까지 <?php echo number_format($count['count']) ?>명이 참여하셨습니다.
        </div>

        <?php
          } else {
            $db->update('simsim_counts', array(
              'count' => $db->inc(1),
            ));
        ?>
          <h2 class="title"><?php echo $name; ?>님을 위한 심상정책!</h2>

          <?php
            foreach ($choiceIds as $choiceId) {
              $choice = $choices[$choiceId];
          ?>

            <div class="choice">
              <?php
                if ($choice['link']) {
              ?>
                <a href="<?php echo $choice['link']; ?>">
              <?php
                }
              ?>
                <div class="choice-header">
                  <img src="<?php echo $choice['image']; ?>"/>
                  <div class="caption"><?php echo $choice['caption']; ?></div>
                </div>
              <?php
                if ($choice['link']) {
              ?>
                </a>
              <?php
                }
              ?>

              <ul class="policies">
                <?php
                  foreach ($choice['policies'] as $policy) {
                ?>

                <li>
                  <?php echo $policy['title'] ?>
                </li>

                <?php
                  }
                ?>
              </ul>
            </div>
          <?php
            }
          ?>

          <div class="button-wrapper top">
            <a class="button go" href="http://as.justice21.org/v19n10/">
              심상정책 더보기
            </a>
          </div>

          <div class="button-wrapper top">
            <a class="button go" target="_blank"
              href="http://simkoong.org/document/main.php">
              복채 내기
            </a>
          </div>

          <div class="button-wrapper">
            <a class="button facebook" target="_blank"
              href="https://www.facebook.com/dialog/feed?&app_id=1893797674169551&display=popup&link=http://minsim.or.kr/simsim/">페이스북 공유하기</a>
          </div>
          <div class="button-wrapper">
            <a class="button twitter" target="_blank"
              href="https://twitter.com/intent/tweet?text=심심철학관&url=http://minsim.or.kr/simsim/">트위터 공유하기</a>
          </div>
          <div class="button-wrapper">
            <a class="button kakao" id="kakao" href="javascript:sendLink()">카카오톡 공유하기</a>
          </div>
          <div class="button-wrapper">
            <a class="button telegram" target="_blank"
              href="https://telegram.me/share/url?url=http://minsim.or.kr/simsim/">텔레그램 공유하기</a>
          </div>
          <div class="button-wrapper">
            <a class="button back" href="/simsim/">돌아가기</a>
          </div>

        <?php } ?>
      </div>
    </div>

    <div class="footer-background">
      <p>Created by <a href="http://www.justice21.org/newhome/main/" target="_blank">정의당</a></p>
      <p>Developed by <a href="http://leehankyeol.me" target="_blank">이한결</a></p>
    </div>

    <script src="./assets/script.js"></script>
    <script type='text/javascript'>
    //<![CDATA[
      // Set JavaScript Key of current app.
      Kakao.init('6b5031f5fecac6acd1bb61429c0a83c9');
      function sendLink() {
        Kakao.Link.sendDefault({
          objectType: 'feed',
          content: {
            title: '심심철학관',
            imageUrl: 'http://minsim.or.kr/simsim/assets/images/title.png',
            imageWidth: 720,
            imageHeight: 375,
            link: {
              webUrl: 'http://minsim.or.kr/simsim',
              mobileWebUrl: 'http://minsim.or.kr/simsim',
            },
            description: '내 눈을 바라봐 넌 심상정 찍고',
          },
          buttonTitle: '심심철학관 가기',
        });
      }
    //]]>
    </script>
  </body>

</html>
