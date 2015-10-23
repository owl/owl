Feature: Search Test
    tests for search/* pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/search?q=testtesttest"
        Then I should be on "/search?q=testtesttest"
        Then I should see "検索結果"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/search?q=testtesttest"
        Then I should be on "/search?q=testtesttest"
        Then I should see "検索結果"
        Then the response status code should be 200
