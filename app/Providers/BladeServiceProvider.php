<?php

namespace App\Providers;

use App\Models\Commit;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Paginator::useTailwind();

        $this->registerDirectives();
    }

    private function registerDirectives()
    {
        Blade::directive('active', function ($expression) {
            return "<?php echo active_classes({$expression}); ?>";
        });
    }
}
