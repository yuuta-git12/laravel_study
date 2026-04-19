<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use App\Models\Admin;
use App\Models\Book;

/**
 * 書籍ポリシー
 *
 * Bookモデルに対する各操作（閲覧・作成・更新・削除）の認可ルールを定義する
 * BookControllerのコンストラクタでauthorizeResource()により自動的に適用される
 */
class BookPolicy
{
    /**
     * ポリシーのコンストラクタ
     */
    public function __construct()
    {
        //
    }

    /**
     * 書籍一覧の閲覧を認可する
     *
     * ログイン済み管理者であれば全員閲覧可能
     *
     * @param Admin $admin ログイン中の管理者
     * @return bool
     */
    public function viewAny(Admin $admin){
        return true;
    }

    /**
     * 書籍詳細の閲覧を認可する
     *
     * ログイン済み管理者であれば全員閲覧可能
     *
     * @param Admin $admin ログイン中の管理者
     * @param Book $book 対象の書籍
     * @return bool
     */
    public function view(Admin $admin, Book $book){
        return Gate::allows('example-com-user');
    }

    /**
     * 書籍の新規作成を認可する
     *
     * login_idの末尾が'example.com'の管理者のみ作成可能
     *
     * @param Admin $admin ログイン中の管理者
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        // login_idの末尾11文字が'example.com'かどうかを確認する
        return Gate::allows('example-com-user');
    }


    // Bookモデルの更新時の認可を行うメソッド
    // ログインユーザーと書籍の作成者が一致する必要がある
    public function update(Admin $admin, Book $book): bool
    {
        return $admin->id === $book->admin_id;
    }

    // Bookモデルの削除時の認可を行うメソッド
    // ログインユーザーと書籍の作成者が一致する必要がある
    public function delete(Admin $admin, Book $book): bool
    {
        return $admin->id === $book->admin_id;
    }
}
