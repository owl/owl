Feature: Login Test
    tests for login pages.

    # Normal Test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/login"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/login"
        Then I should be on "/"
        Then I should see "投稿する"
        Then the response status code should be 200

    # Abnormal Test
    Scenario: validation error when fill in with wrong username
        Given I am on the homepage
        When I go to "/login"
        When I fill in "username" with "testtesttest"
        When I fill in "password" with "password"
        When I press "ログイン"
        Then I should be on "/login"
        Then I should see "ユーザ名又はパスワードが正しくありません"
        Then the response status code should be 200

    Scenario: validation error when fill in with only username
        Given I am on the homepage
        When I go to "/login"
        When I fill in "username" with "testtesttest"
        When I fill in "password" with ""
        When I press "ログイン"
        Then I should be on "/login"
        Then I should see "パスワードは必須です。"
        Then the response status code should be 200

    Scenario: validation error when fill in with empty params
        Given I am on the homepage
        When I go to "/login"
        When I fill in "username" with ""
        When I fill in "password" with ""
        When I press "ログイン"
        Then I should be on "/login"
        Then I should see "ユーザ名は必須です。"
        Then I should see "パスワードは必須です。"
        Then the response status code should be 200
