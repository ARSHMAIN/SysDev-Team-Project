<?php

use MyApp\Models\CartItem;
use MyApp\Models\KnownPossibleMorph;
use MyApp\Models\Sex;
use MyApp\Models\Snake;
use MyApp\Models\Test;
use MyApp\Models\TestedMorph;

class CacheMiddleware
{
    public static function cacheCart(): void
    {
        $cartItems = CartItem::geCartItemByCartIdAndUserId($_SESSION['user_id']);
        $donations = [];
        $tests = [];
        if ($cartItems) {
            foreach ($cartItems as $item) {
                if ($item->getDonationId() !== null) {
                    $donation = null;
                    $donations[] = $donation;
                } else if ($item->getTestId() !== null) {
                    $test = new Test($item->getTestId());
                    $snake = new Snake($test->getSnakeId());
                    $customerSnakeId = new CustomerSnakeName($snake->getSnakeId());
                    $sex = new Sex($snake->getSexId());
                    $knownMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), true);
                    $possibleMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), false);
                    $testedMorphs = TestedMorph::getAllTestedMorphById($test->getTestId());
                    $tests[] = [
                        'testId' => $test->getTestId(),
                        'customerSnakeId' => $customerSnakeId->getCustomerSnakeId(),
                        'sex' => $sex->getSexName(),
                        'origin' => $snake->getSnakeOrigin(),
                        'knownMorphs' => Morph::getMorphNames($knownMorphs),
                        'possibleMorphs' => Morph::getMorphNames($possibleMorphs),
                        'testedMorphs' => Morph::getMorphNames($testedMorphs)
                    ];
                }
            }
            $this->render(['tests' => $tests, 'donations' => $donations]);
        }
    }
}