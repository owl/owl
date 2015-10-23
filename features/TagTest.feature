Feature: Item Test
    tests for tags/* pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/tags"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/tags"
        Then I should be on "/tags"
        Then I should see "タグ一覧"
        Then the response status code should be 200
