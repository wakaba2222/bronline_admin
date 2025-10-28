<!--{%assign var=pref_name value=""%}-->
<!--{%foreach $arrPref as $pref %}-->
<!--{%if $arrForm['pref'] == $pref['id']%}-->
<!--{%assign var=pref_name value=$pref['name']%}-->
<!--{%/if%}-->
<!--{%/foreach%}-->

<!--{%$arrForm['name01']%}-->　<!--{%$arrForm['name02']%}-->様

B.R.ONLINE

ご予約ありがとうございます。
以下の内容で受け付けました。
折り返し担当よりご連絡させていただきますので、今しばらくお待ちくださいませ。

お名前：<!--{%$arrForm['name01']%}-->　<!--{%$arrForm['name02']%}-->
フリガナ：<!--{%$arrForm['kana01']%}-->　<!--{%$arrForm['kana02']%}-->
お住まいの都道府県：<!--{%$pref_name%}-->　<!--{%$arrForm['addr01']%}-->　<!--{%$arrForm['addr02']%}-->
電話番号：<!--{%$arrForm['tel01']%}-->
メールアドレス：<!--{%$arrForm['email']%}-->
ご予約内容：<!--{%$arrForm['body']%}-->
