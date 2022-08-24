<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>プロフィール設定</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$('form.profileForm').submit(() => {
  const nickname = $('input.nickname').val();// テキストボックスのvalue値を取得
  const gender = $('input.gender').val();
  const age = $('input.age').val();
  const bloodtype = $('input.bloodtype').val();
  const residence = $('input.residence').val();
  const height = $('input.height').val();
  const body = $('input.body').val();
  const character = $('input.character').val();
  const hope = $('input.hope').val();
  const hobby = $('input.hobby').val();
  const area = $('input.area').val();
  const points = $('input.points').val();
  const selfintroduction = $('input.selfintroduction').val();

        $.ajax({
            type: "POST", //HTTP通信の種類
            url: '/api/profiles', //通信したいURL
            data: { nickname,gender,age,bloodtype,residence,height,body,character,hope,hobby,area,points,selfintroduction } ,
            dataType: 'json'
        })
            .done((res) => {
                console.log(res);
                // 下記のみ不要なのでコメントアウト
                //$('input.text1').val(res.nickname);
                //$("#span1").text(nickname); // spanタグに値を設定
            })
            .fail((error) => {
                console.log(error);
            })
    });
</script>
</head>

<p>プロフィール設定</p>
    <form id="profileForm">
        <div class="form-profile">
            <label for="name">ニックネーム: </label>
            <input type="text" value="" id="nickname" maxlength="100" />
        </div>
        <div class="form-profile">
            <label for="gender">性別:</label>
            <select name="gender" id="gender">
                <option value="">--性別を選択して下さい--</option>
                <option value="dog">男性</option>
                <option value="cat">女性</option>
            </select>
        </div>
        <div class="form-profile">
            <label for="age">年齢: </label>
            <input type="text" value="" id="age" maxlength="3" />
        </div>
        <div class="form-profile">
            <label for="bloodtype">血液型:</label>
            <select name="bloodtype" id="bloodtype">
                <option value="">--血液型を選択して下さい--</option>
                <option value="dog">A型</option>
                <option value="cat">B型</option>
                <option value="dog">O型</option>
                <option value="cat">AB型</option>
            </select>
        </div>
        <div class="form-profile">
            <label for="residence">居住地:</label>
            <select name="residence" id="residence">
                <option value="">--居住地を選択して下さい--</option>
                <option value="dog">東京</option>
                <option value="cat">埼玉</option>
                <option value="dog">千葉</option>
                <option value="cat">神奈川</option>
            </select>
        </div>
        <div class="form-profile">
            <label for="height">身長:</label>
            <select name="height" id="height">
                <option value="">--身長を選択して下さい--</option>
                <option value="dog">130㎝〜140cm</option>
                <option value="cat">140㎝〜150cm</option>
                <option value="dog">150㎝〜160cm</option>
                <option value="cat">160㎝〜170cm</option>
                <option value="cat">170㎝〜180cm</option>
                <option value="cat">180㎝〜190cm</option>
            </select>
        </div>
        <div class="form-profile">
            <label for="body">体型:</label>
            <select name="body" id="body">
                <option value="">--体型を選択して下さい--</option>
                <option value="dog">スリム</option>
                <option value="cat">普通</option>
                <option value="dog">グラマー</option>
                <option value="cat">筋肉質</option>
                <option value="cat">ややぽっちゃり</option>
                <option value="cat">ぽっちゃり</option>
            </select>
        </div>


        <div class="form-profile">
            <input type="submit" id="button1" value="登録" />
        </div>
    </form>
</html>

