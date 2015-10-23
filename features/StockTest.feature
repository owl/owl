Feature: Stock Test
    tests for /stocks pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/stocks"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/stocks"
        Then I should be on "/stocks"
        Then I should see "ストック一覧"
        Then the response status code should be 200
