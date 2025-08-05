<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeFluxIcon extends Command
{
    protected $signature = 'make:icon {name}';
    protected $description = 'Tạo Blade file icon trong thư mục resources/views/flux/icon';

    public function handle()
    {
        $name = $this->argument('name');
        $slug = Str::kebab($name);
        $path = resource_path("views/flux/icon/{$slug}.blade.php");

        if (File::exists($path)) {
            $this->error("❌ Icon [{$slug}] đã tồn tại!");
            return Command::FAILURE;
        }

        File::ensureDirectoryExists(dirname($path));

        File::put($path, <<<BLADE
            @php \$attributes = \$unescapedForwardedAttributes ?? \$attributes; @endphp
            @props([
                'variant' => 'outline', // Các biến thể: outline, mini, micro
            ])

            @php
                if (\$variant === 'solid') {
                    throw new \Exception('The "solid" variant is not supported in Lucide.');
                }

                \$classes = Flux::classes('shrink-0')->add(
                    match (\$variant) {
                        'outline' => '[:where(&)]:size-6',
                        'mini' => '[:where(&)]:size-5',
                        'micro' => '[:where(&)]:size-4',
                        default => '[:where(&)]:size-6',
                    },
                );

                \$strokeWidth = match (\$variant) {
                    'outline' => 2,
                    'mini' => 2.25,
                    'micro' => 2.5,
                    default => 2,
                };
            @endphp

            <svg {{ \$attributes->class(\$classes) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="{{ \$strokeWidth }}" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true" data-slot="icon" data-flux-icon>
                {{-- <path d="..." /> --}}
            </svg>
            BLADE);

        $this->info("✅ Đã tạo icon: resources/views/flux/icon/{$slug}.blade.php");
        return Command::SUCCESS;
    }
}
