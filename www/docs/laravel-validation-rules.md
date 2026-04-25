# Laravel バリデーションルール まとめ

> 情報ソース: [Laravel 12.x 公式ドキュメント - Validation](https://laravel.com/docs/12.x/validation)

---

## 目次

1. [基本的な使い方](#基本的な使い方)
2. [存在・必須系](#存在必須系)
3. [文字列・型系](#文字列型系)
4. [数値系](#数値系)
5. [日付系](#日付系)
6. [配列系](#配列系)
7. [ファイル系](#ファイル系)
8. [比較・条件系](#比較条件系)
9. [DB連携系](#db連携系)
10. [フォーマット系](#フォーマット系)
11. [Passwordルール](#passwordルール)
12. [カスタムルール](#カスタムルール)

---

## 基本的な使い方

```php
// FormRequest の rules() 内で定義
public function rules(): array
{
    return [
        'field' => ['rule1', 'rule2'],
        // または文字列でパイプ区切り
        'field' => 'rule1|rule2',
    ];
}
```

---

## 存在・必須系

| ルール | 説明 |
|---|---|
| `required` | 必須（空文字・null・未送信は NG） |
| `nullable` | null を許可（required と組み合わせ不可） |
| `sometimes` | フィールドが送信された場合のみ検証 |
| `present` | フィールドが存在することを要求（値は空でも可） |
| `filled` | 送信された場合は空でないことを要求 |
| `required_if:field,value` | 他フィールドが特定値のとき必須 |
| `required_unless:field,value` | 他フィールドが特定値でないとき必須 |
| `required_with:field1,field2` | 指定フィールドのいずれかが存在するとき必須 |
| `required_with_all:field1,field2` | 指定フィールドすべてが存在するとき必須 |
| `required_without:field1,field2` | 指定フィールドのいずれかが存在しないとき必須 |
| `required_without_all:field1,field2` | 指定フィールドすべてが存在しないとき必須 |
| `required_array_keys:key1,key2` | 配列に指定キーが含まれるとき必須 |
| `prohibited` | フィールドが存在してはいけない |
| `prohibited_if:field,value` | 他フィールドが特定値のとき禁止 |
| `prohibited_unless:field,value` | 他フィールドが特定値でないとき禁止 |
| `exclude` | バリデーション後のデータから除外 |
| `exclude_if:field,value` | 条件付きで除外 |
| `exclude_unless:field,value` | 条件付きで除外 |
| `exclude_with:field` | 指定フィールドがある場合除外 |
| `exclude_without:field` | 指定フィールドがない場合除外 |

---

## 文字列・型系

| ルール | 説明 |
|---|---|
| `string` | 文字列であること |
| `alpha` | 英字のみ |
| `alpha_num` | 英数字のみ |
| `alpha_dash` | 英数字・ハイフン・アンダースコアのみ |
| `alpha_num:ascii` | ASCII英数字のみ |
| `uppercase` | 大文字のみ |
| `lowercase` | 小文字のみ |
| `email` | メールアドレス形式 |
| `email:rfc,dns` | RFC準拠 + DNS検証 |
| `url` | URL形式 |
| `active_url` | 実際に存在するURL（DNS解決） |
| `ip` | IPアドレス（v4またはv6） |
| `ipv4` | IPv4アドレス |
| `ipv6` | IPv6アドレス |
| `mac_address` | MACアドレス形式 |
| `uuid` | UUID形式 |
| `ulid` | ULID形式 |
| `json` | JSON文字列 |
| `boolean` | true/false/1/0/"1"/"0" |
| `integer` | 整数（文字列でも可） |
| `numeric` | 数値（整数・小数） |
| `decimal:min,max` | 小数点以下の桁数を指定 |
| `array` | 配列 |
| `list` | 連番インデックスの配列 |
| `min:value` | 最小値・最小文字数・最小要素数 |
| `max:value` | 最大値・最大文字数・最大要素数 |
| `size:value` | 値・文字数・要素数が指定値と等しい |
| `between:min,max` | 値・文字数・要素数が範囲内 |
| `regex:/pattern/` | 正規表現にマッチ |
| `not_regex:/pattern/` | 正規表現にマッチしない |
| `starts_with:foo,bar` | 指定文字列のいずれかで始まる |
| `ends_with:foo,bar` | 指定文字列のいずれかで終わる |
| `doesnt_start_with:foo` | 指定文字列で始まらない |
| `doesnt_end_with:foo` | 指定文字列で終わらない |
| `contains:foo,bar` | 指定値をすべて含む（配列） |

---

## 数値系

| ルール | 説明 |
|---|---|
| `integer` | 整数 |
| `numeric` | 数値（整数・小数） |
| `min:value` | 最小値 |
| `max:value` | 最大値 |
| `between:min,max` | 範囲内 |
| `lt:field` | 指定フィールドより小さい |
| `lte:field` | 指定フィールド以下 |
| `gt:field` | 指定フィールドより大きい |
| `gte:field` | 指定フィールド以上 |
| `multiple_of:value` | 指定値の倍数 |

---

## 日付系

| ルール | 説明 |
|---|---|
| `date` | 有効な日付 |
| `date_format:Y-m-d` | 指定フォーマットの日付 |
| `date_equals:date` | 指定日付と等しい |
| `before:date` | 指定日付より前 |
| `before_or_equal:date` | 指定日付以前 |
| `after:date` | 指定日付より後 |
| `after_or_equal:date` | 指定日付以降 |
| `timezone` | 有効なタイムゾーン文字列 |

---

## 配列系

| ルール | 説明 |
|---|---|
| `array` | 配列であること |
| `array:key1,key2` | 許可されたキーのみを含む配列 |
| `list` | 連番インデックス配列（0始まり） |
| `min:value` | 最小要素数 |
| `max:value` | 最大要素数 |
| `size:value` | 要素数が指定値と等しい |
| `between:min,max` | 要素数が範囲内 |
| `distinct` | 配列内の値が重複しない |
| `in_array:other.*` | 他の配列フィールドの値に含まれる |

---

## ファイル系

| ルール | 説明 |
|---|---|
| `file` | アップロードされたファイル |
| `image` | 画像ファイル（jpeg/png/gif/bmp/svg/webp） |
| `mimes:jpeg,png` | 指定MIMEタイプ |
| `mimetypes:image/jpeg` | 指定MIMEタイプ（直接指定） |
| `extensions:jpg,png` | 指定拡張子 |
| `min:value` | 最小ファイルサイズ（KB） |
| `max:value` | 最大ファイルサイズ（KB） |
| `size:value` | ファイルサイズが指定値（KB） |
| `dimensions:min_width=100` | 画像の寸法制約 |

---

## 比較・条件系

| ルール | 説明 |
|---|---|
| `same:field` | 指定フィールドと同じ値 |
| `different:field` | 指定フィールドと異なる値 |
| `confirmed` | `field_confirmation` フィールドと一致（パスワード確認等） |
| `in:value1,value2` | 指定値のいずれか |
| `not_in:value1,value2` | 指定値以外 |
| `accepted` | "yes"/"on"/"1"/true のいずれか（利用規約同意等） |
| `accepted_if:field,value` | 条件付き accepted |
| `declined` | "no"/"off"/"0"/false のいずれか |
| `declined_if:field,value` | 条件付き declined |

---

## DB連携系

| ルール | 説明 |
|---|---|
| `exists:table,column` | 指定テーブルのカラムに値が存在する |
| `unique:table,column` | 指定テーブルのカラムで値が一意 |
| `unique:table,column,ignore_id` | 自分自身のIDを除外して一意チェック |

```php
// Rule::exists / Rule::unique を使う書き方（推奨）
use Illuminate\Validation\Rule;

'email' => ['required', Rule::unique('users')->ignore($user->id)],
'category_id' => ['required', Rule::exists('categories', 'id')],
```

---

## フォーマット系

| ルール | 説明 |
|---|---|
| `email` | メールアドレス |
| `url` | URL |
| `active_url` | DNS解決できるURL |
| `ip` / `ipv4` / `ipv6` | IPアドレス |
| `uuid` | UUID |
| `ulid` | ULID |
| `json` | JSON文字列 |
| `mac_address` | MACアドレス |
| `hex_color` | 16進数カラーコード |
| `ascii` | ASCII文字のみ |

---

## Passwordルール

`Illuminate\Validation\Rules\Password` クラスで強力なパスワードポリシーを設定できる。

```php
use Illuminate\Validation\Rules\Password;

'password' => [
    'required',
    'string',
    'max:10',
    Password::min(8)        // 最小8文字
        ->max(10)           // 最大10文字（Laravel 11+）
        ->letters()         // 英字を含む
        ->mixedCase()       // 大文字・小文字を含む
        ->numbers()         // 数字を含む
        ->symbols()         // 記号を含む
        ->uncompromised(),  // データ漏洩リストに含まれない（Have I Been Pwned）
],
```

### AppServiceProvider でデフォルトを設定する方法

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Validation\Rules\Password;

public function boot(): void
{
    Password::defaults(function () {
        return Password::min(8)->numbers()->symbols();
    });
}

// rules() 内では以下で呼び出す
'password' => ['required', Password::defaults()],
```

---

## カスタムルール

### Rule オブジェクト（推奨）

```bash
php artisan make:rule Uppercase
```

```php
// app/Rules/Uppercase.php
class Uppercase implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strtoupper($value) !== $value) {
            $fail('The :attribute must be uppercase.');
        }
    }
}

// 使用例
'name' => ['required', new Uppercase],
```

### クロージャで定義

```php
'name' => [
    'required',
    function (string $attribute, mixed $value, Closure $fail) {
        if (strtoupper($value) !== $value) {
            $fail("The {$attribute} must be uppercase.");
        }
    },
],
```

---

## カスタムエラーメッセージ

### FormRequest 内で定義

```php
public function messages(): array
{
    return [
        'email.required' => 'メールアドレスは必須です。',
        'password.max' => 'パスワードは :max 文字以内で入力してください。',
    ];
}
```

### 属性名の日本語化

```php
public function attributes(): array
{
    return [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ];
}
```

---

## 情報ソース

| ソース | URL |
|---|---|
| Laravel 12.x 公式ドキュメント（バリデーション） | https://laravel.com/docs/12.x/validation |
| Laravel 12.x 利用可能なルール一覧 | https://laravel.com/docs/12.x/validation#available-validation-rules |
| Laravel 12.x Password ルール | https://laravel.com/docs/12.x/validation#validating-passwords |
| Laravel 12.x カスタムルール | https://laravel.com/docs/12.x/validation#custom-validation-rules |
