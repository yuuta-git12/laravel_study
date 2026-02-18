<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Book;

/**
 * 書籍フォームコンポーネント
 * 書籍の新規登録(create)と編集(edit)で共通利用するフォームコンポーネント
 * コンストラクタのデフォルト値により、新規登録時はプロパティを省略して呼び出せる
 */
class BookForm extends Component
{
    /**
     * コンポーネントのインスタンスを生成する
     *
     * @param Collection $categories カテゴリ一覧（セレクトボックス用）
     * @param Collection $authors    著者一覧（チェックボックス用）
     * @param Book       $book       編集対象の書籍（新規登録時は空のBookインスタンス）
     * @param array      $authorIds  書籍に紐づく著者IDの配列（新規登録時は空配列）
     */
    public function __construct(
        // コンポーネントに渡す値
        public Collection $categories,
        public Collection $authors,
        public Book $book = new Book(), // create bladeでも使用できるようにデフォルト値を渡す
        public array $authorIds = [],   // create bladeでも使用できるようにデフォルト値を渡す
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.book-form');
    }
}
