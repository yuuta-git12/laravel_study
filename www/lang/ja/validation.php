<?php

/**
 * 日本語バリデーションメッセージ定義ファイル
 *
 * Laravelのバリデーションエラーメッセージを日本語で定義する
 * フォーム入力時のバリデーションエラー表示に使用される
 */
return [
    // バリデーションエラーメッセージの定義
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

    // フォーム属性名の日本語定義（エラーメッセージ内の :attribute を置換する）
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
