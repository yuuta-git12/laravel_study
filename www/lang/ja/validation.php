<?php
return [
    //　エラーメッセージを設定
    'exists' => '正しい :attributeを選択してください。',
    'max' => [
        'numeric' => ':attribute は :max以下を入力してください。',
        'string' => ':attribute は :max文字以内で入力してください',
    ],
    'min' => [
        'numeric' => ':attribute は :min以上を入力してください。',
        'string' => ':attribute は :min文字以上で入力してください',
    ],
    'numeric' => ':attributeは数値で入力してください。',
    'required' => ':attributeは必須入力です',
    'unique' => ':attributeはすでに登録されています。',

    // キー名も日本語に変更
    'attributes' => [
        'category_id' => 'カテゴリ',
        'title' => 'タイトル',
        'price' => '価格',
        // 著者IDの配列全体に対する属性名
        'author_ids' => '著者',
        // 著者ID配列の各要素に対する属性名（ワイルドカード「*」で配列の各要素を指定）
        'author_ids.*' => '著者',
    ],
]

?>
