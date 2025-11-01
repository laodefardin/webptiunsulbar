<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use App\Filament\Resources\LecturerResource;
use App\Filament\Resources\PageResource;
use App\Filament\Resources\PostResource;
use App\Models\Event;
use App\Models\Lecturer;
use App\Models\Page;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
            protected function getStats(): array
        {
            return [
                Stat::make('Total Berita', Post::count())
                    ->description('Jumlah semua berita yang telah dibuat')
                    ->descriptionIcon('heroicon-o-arrow-trending-up')
                    ->color('success')
                    ->icon('heroicon-o-newspaper')
                    ->url(PostResource::getUrl('index')),

                Stat::make('Total Halaman', Page::count())
                    ->description('Jumlah semua halaman statis')
                    ->descriptionIcon('heroicon-o-document-text')
                    ->color('info')
                    ->icon('heroicon-o-document-text')
                    ->url(PageResource::getUrl('index')),

                Stat::make('Total Agenda', Event::count())
                    ->description('Jumlah semua agenda kegiatan')
                    ->descriptionIcon('heroicon-o-calendar-days')
                    ->color('warning')
                    ->icon('heroicon-o-calendar-days')
                    ->url(EventResource::getUrl('index')),

                Stat::make('Total Dosen', Lecturer::count())
                    ->description('Jumlah semua data dosen & staff')
                    ->descriptionIcon('heroicon-o-academic-cap')
                    ->color('primary')
                    ->icon('heroicon-o-academic-cap')
                    ->url(LecturerResource::getUrl('index')),
            ];
        }
}
