Feature: Signup Test
    tests for /signup pages.

    # Smoke test
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
