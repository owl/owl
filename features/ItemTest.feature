Feature: Item Test
    tests for item/* pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/items"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/items"
        Then I should be on "/items"
        Then I should see "すべての投稿"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/items/create"
        Then I should be on "/items/create"
        Then I should see "新規投稿"
        Then the response status code should be 200

