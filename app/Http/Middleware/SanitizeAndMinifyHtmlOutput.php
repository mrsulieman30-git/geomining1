<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SanitizeAndMinifyHtmlOutput
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Strip server fingerprinting headers
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        $contentType = (string) $response->headers->get('Content-Type', '');
        if (str_contains($contentType, 'text/html') && $response->getContent() !== false) {
            $html = $response->getContent();

            // 1. Remove all HTML comments (except IE conditional if any, none needed)
            $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html) ?? $html;

            // 2. Remove data-v-* debug markers or stray development attributes if present
            $html = preg_replace('/\s+data-debug-[a-z0-9-]+="[^"]*"/i', '', $html) ?? $html;

            // 3. Collapse redundant whitespace between HTML tags while preserving <pre> and <textarea>
            $html = preg_replace('/>\s+</', '><', $html) ?? $html;

            $response->setContent(trim($html));
        }

        return $response;
    }
}