Feature: Signup Test
    tests for /signup pages.

    # Normal Test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/signup"
        Then I should be on "/signup"
        Then I should see "新規登録"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/signup"
        Then I should be on "/"
        Then I should see "投稿する"
        Then the response status code should be 200

    Scenario: Create user (fill in all with correct params)
        Given I am on the homepage
        When I create random user
        Then I should be on "/login"
        Then I should see "登録が完了しました"
        Then the response status code should be 200

    # Abnormal Test
    Scenario: validation error when fill in with empty params
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with ""
        When I fill in "email" with ""
        When I fill in "password" with ""
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "ユーザ名は必須です"
        Then I should see "Emailは必須です"
        Then I should see "パスワードは必須です"
        Then the response status code should be 200

    Scenario: validation error when fill in with username which katakana
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "カタカナ"
        When I fill in "email" with "test@example.com"
        When I fill in "password" with "password"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "ユーザ名にはアルファベット、数字以外使用できません"
        Then the response status code should be 200

    Scenario: validation error when fill in with username which reserved word
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "item"
        When I fill in "email" with "test@example.com"
        When I fill in "password" with "password"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "このユーザ名を使用することはできません"
        Then the response status code should be 200

    Scenario: validation error when fill in with username which over 30 characters
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "llllllllllllllllllllllllllllll31"
        When I fill in "email" with "test@example.com"
        When I fill in "password" with "password"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "ユーザ名の長さは30文字以下である必要があります"
        Then the response status code should be 200

    Scenario: validation error when fill in with username which already exists
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "admin"
        When I fill in "email" with "test@example.com"
        When I fill in "password" with "password"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "このユーザ名を使用することはできません"
        Then the response status code should be 200

    Scenario: validation error when fill in with email which email-style
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "testuser"
        When I fill in "email" with "testtesttest"
        When I fill in "password" with "password"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "このEmailは正しいメールアドレスではありません"
        Then the response status code should be 200

    Scenario: validation error when fill in with email which already exists
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "testuser"
        When I fill in "email" with "admin@example.com"
        When I fill in "password" with "password"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "このEmailはすでに使われています"
        Then the response status code should be 200

    Scenario: validation error when fill in with password which katakana
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "testuser"
        When I fill in "email" with "admin@example.com"
        When I fill in "password" with "パスワード"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "パスワードにはアルファベット、数字以外使用できません"
        Then the response status code should be 200

    Scenario: validation error when fill in with password which under 4 characters
        Given I am on the homepage
        When I go to "/signup"
        When I fill in "username" with "testuser"
        When I fill in "email" with "test@example.com"
        When I fill in "password" with "abc"
        When I press "登録"
        Then I should be on "/signup"
        Then I should see "パスワードの長さは 4文字以上である必要があります"
        Then the response status code should be 200
