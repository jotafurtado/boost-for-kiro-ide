<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro\Steering;

use RuntimeException;

class SteeringWriter
{
    public const WRITTEN = 0;

    public const UPDATED = 1;

    public const FAILED = 2;

    public function __construct(
        protected string $steeringPath,
        protected string $legacyHooksPath,
    ) {
        //
    }

    /**
     * Write a manual steering markdown file to the steering directory.
     *
     * @return self::WRITTEN|self::UPDATED|self::FAILED
     */
    public function write(string $filename, string $markdown): int
    {
        $directory = base_path($this->steeringPath);

        if (! is_dir($directory) && ! @mkdir($directory, 0755, true)) {
            throw new RuntimeException("Failed to create directory: {$directory}");
        }

        $filePath = $directory.DIRECTORY_SEPARATOR.$filename.'.md';
        $existed = file_exists($filePath);

        if (file_put_contents($filePath, $markdown."\n") === false) {
            return self::FAILED;
        }

        return $existed ? self::UPDATED : self::WRITTEN;
    }

    /**
     * Remove steering files that are no longer needed, and clean up any
     * legacy `.kiro.hook` files left over from Kiro 0.x.
     *
     * @param  array<int, string>  $currentFilenames
     * @return array<string, bool>
     */
    public function removeStale(array $currentFilenames): array
    {
        $results = $this->removeGlob($this->steeringPath, 'boost-prompt-*.md', '.md', $currentFilenames);

        // One-time cleanup of legacy Kiro 0.x hook files.
        $results = array_merge(
            $results,
            $this->removeGlob($this->legacyHooksPath, 'boost-prompt-*.kiro.hook', '.kiro.hook', []),
        );

        return $results;
    }

    /**
     * @param  array<int, string>  $keep
     * @return array<string, bool>
     */
    protected function removeGlob(string $path, string $glob, string $suffix, array $keep): array
    {
        $directory = base_path($path);
        $results = [];

        if (! is_dir($directory)) {
            return $results;
        }

        $existingFiles = glob($directory.DIRECTORY_SEPARATOR.$glob) ?: [];

        foreach ($existingFiles as $filePath) {
            $basename = basename($filePath, $suffix);

            if (! in_array($basename, $keep, true)) {
                $results[$basename] = @unlink($filePath);
            }
        }

        return $results;
    }
}
