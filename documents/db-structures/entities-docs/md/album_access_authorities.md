# アルバムアクセス権限設定 (album_access_authorities)

## テーブル情報

| 項目                           | 値                                                                                                   |
|:-------------------------------|:-----------------------------------------------------------------------------------------------------|
| システム名                     | pict-connect                                                                                         |
| サブシステム名                 |                                                                                                      |
| 論理エンティティ名             | アルバムアクセス権限設定                                                                             |
| 物理エンティティ名             | album_access_authorities                                                                             |
| 作成者                         | Tatsuya Ootani - Oolong                                                                              |
| 作成日                         | 2023/08/05                                                                                           |
| タグ                           |                                                                                                      |



## カラム情報

| No. | 論理名                         | 物理名                         | データ型                       | Not Null | デフォルト           | 備考                           |
|----:|:-------------------------------|:-------------------------------|:-------------------------------|:---------|:---------------------|:-------------------------------|
|   1 | アルバムアクセス権限id         | album_access_authority_id      | BIGINT UNSIGNED                | Yes (PK) |                      |                                |
|   2 | アルバム-写真id                | album_photo_id                 | BIGINT UNSIGNED                | Yes      |                      |                                |
|   3 | アクセストークン               | token                          | varchar(255)                   |          |                      | authorized_user_idが入っていなければ必須 |
|   4 | 承認済みユーザー               | authorized_user_id             | BIGINT UNSIGNED                |          |                      | tokenが入っていなければ必須    |
|   5 | アルバム内容の変更の可否       | is_writable                    | TINYINT(1)                     | Yes      | false                |                                |
|   6 | 作成日時                       | created_at                     | datetime                       |          |                      |                                |
|   7 | 更新日時                       | updated_at                     | datetime                       |          |                      |                                |
|   8 | 削除日時                       | deleted_at                     | datetime                       |          |                      |                                |



## インデックス情報

| No. | インデックス名                 | カラムリスト                             | ユニーク   | オプション                     | 
|----:|:-------------------------------|:-----------------------------------------|:-----------|:-------------------------------|



## リレーションシップ情報

| No. | 動詞句                         | カラムリスト                             | 参照先                         | 参照先カラムリスト                       |
|----:|:-------------------------------|:-----------------------------------------|:-------------------------------|:-----------------------------------------|
|   1 |                                | authorized_user_id                       | users                          | user_id                                  |
|   2 |                                | album_photo_id                           | album_photos                   | album_photo_id                           |



## リレーションシップ情報(PK側)

| No. | 動詞句                         | カラムリスト                             | 参照元                         | 参照元カラムリスト                       |
|----:|:-------------------------------|:-----------------------------------------|:-------------------------------|:-----------------------------------------|


