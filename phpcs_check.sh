#!/bin/bash

echo "phpcsによるチェックを開始します..."

# チェック対象のファイルがあるかチェック（ない場合は次のphpcsでエラーが出ないようにexitする）
FILES=$(git diff --name-only --diff-filter=ACMR origin/master...HEAD | grep ".php")
if [ -z "${FILES}" ]; then
    echo "------------------------------------------"
    git diff --name-only --diff-filter=ACMR origin/master...HEAD
    echo "------------------------------------------"
    echo "チェック対象のファイルがありませんでした。"
    exit 0
fi

# phpcsを実行する
RESULT=$(git diff --name-only --diff-filter=ACMR origin/master...HEAD | grep ".php" | xargs vendor/bin/phpcs --standard=./phpcs.xml)
if [ $? -eq 0 ]; then
    echo "------------------------------------------"
    git diff --name-only --diff-filter=ACMR origin/master...HEAD
    echo "------------------------------------------"
    echo "規約違反は発見されませんでした。"
    exit 0
else
    echo "${RESULT}"
    exit 1
fi

echo "phpcsによるチェックを終了します。"
