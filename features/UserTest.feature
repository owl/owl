Feature: User Test
    tests for user/* pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/admin"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/admin"
        Then I should be on "/admin"
        Then I should see "プロフィール"
        Then the response status code should be 200

    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/user/edit"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/user/edit"
        Then I should be on "/user/edit"
        Then I should see "アカウント設定"
        Then the response status code should be 200
