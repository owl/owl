Feature: Stock Test
    tests for /favorites pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/favorites"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/favorites"
        Then I should be on "/favorites"
        Then I should see "お気に入り一覧"
        Then the response status code should be 200
