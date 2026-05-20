<?php

namespace App\Services;

class ChatbotService
{
    /** @return array{reply: string, suggestions: array<int, string>} */
    public function reply(string $message): array
    {
        $normalized = strtolower(trim($message));

        if ($normalized === '') {
            return $this->greeting();
        }

        foreach ($this->knowledgeBase() as $keywords => $answer) {
            foreach (explode('|', $keywords) as $keyword) {
                if (str_contains($normalized, trim($keyword))) {
                    return [
                        'reply' => $answer,
                        'suggestions' => $this->suggestionsFor($keywords),
                    ];
                }
            }
        }

        return [
            'reply' => 'I\'m not sure about that yet. Try asking about orders, shipping, returns, payments, becoming a seller, or your account. You can also check your notifications and order history when logged in.',
            'suggestions' => ['Track my order', 'Shipping info', 'Contact support'],
        ];
    }

    /** @return array{reply: string, suggestions: array<int, string>} */
    private function greeting(): array
    {
        return [
            'reply' => 'Hi! I\'m the CraftNest assistant. I can help with orders, shipping, payments, returns, and seller questions.',
            'suggestions' => ['Track my order', 'How do I checkout?', 'Become a seller'],
        ];
    }

    /** @return array<string, string> */
    private function knowledgeBase(): array
    {
        return [
            'order|track|status|where is' => 'View your orders from the Orders link in the navbar after logging in. Sellers update status to processing, shipped, and delivered — you\'ll get in-app and email alerts when those change.',
            'ship|delivery|deliver|arrive' => 'Shipping details are entered at checkout. Sellers fulfill orders from their shop; delivery times vary by seller. Check your order page for the latest status.',
            'return|refund|cancel' => 'For cancellations or issues, open the order from My Orders and contact the seller through their shop page. Platform admins can help with disputes from admin review of orders.',
            'pay|payment|cod|card|checkout' => 'CraftNest supports Cash on Delivery (COD) and a simulated card payment at checkout. Your cart is saved in your session until you complete checkout while logged in.',
            'cart|basket|add' => 'Browse the marketplace, open a product, choose quantity, and click Add to cart. View your cart anytime from the Cart link in the top navigation.',
            'wishlist|favorite|heart|save' => 'Tap the heart on a product to save it to your wishlist (login required). Open Wishlist from the navbar to move items to cart or remove them.',
            'review|rating|star' => 'You can leave one review per product after a verified purchase. Ratings appear on the product page and help other buyers.',
            'seller|sell|shop|open store|artisan' => 'Register as a Seller, then open Seller Studio from your account to create your shop, add products, and manage orders. Demo seller: seller@craftnest.test',
            'account|login|register|password|sign' => 'Use Login or Join in the navbar. Buyers browse and buy; sellers run shops. Forgot password? Use the link on the login page for a reset email.',
            'stock|out of stock|available' => 'Product pages show stock status. If something is out of stock, you won\'t be able to add more than available quantity to your cart.',
            'notification|alert|email' => 'Order and review updates appear in the bell icon when logged in. Email alerts are sent for key order events when mail is configured in .env.',
            'help|support|contact|human' => 'For account or order help, email support@craftnest.com (demo). Check Notifications and Orders first — most answers are there.',
            'craftnest|marketplace|what is|about' => 'CraftNest is a multi-vendor handmade marketplace — like Etsy for artisans. Browse goods, support independent makers, or open your own shop.',
        ];
    }

    /** @return array<int, string> */
    private function suggestionsFor(string $matchedKey): array
    {
        return match (true) {
            str_contains($matchedKey, 'order') => ['Shipping info', 'Payment methods', 'Returns'],
            str_contains($matchedKey, 'seller') => ['How do I checkout?', 'Track my order', 'Reviews'],
            str_contains($matchedKey, 'pay') => ['Track my order', 'Cart help', 'Become a seller'],
            default => ['Track my order', 'Become a seller', 'Contact support'],
        };
    }
}
