<?php
declare(strict_types=1);

namespace Panth\CacheManager\Console\Command;

use Magento\Framework\App\State as AppState;
use Panth\CacheManager\Cron\WarmupCache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WarmupCommand extends Command
{
    private const NAME = 'panth:cachemanager:warmup';

    public function __construct(
        private readonly WarmupCache $warmer,
        private readonly AppState $appState
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Run a synchronous cache warmup using the configured panth_cachemanager pages and concurrency.')
            ->addOption(
                'quiet-rows',
                null,
                InputOption::VALUE_NONE,
                'Suppress the per-URL progress table; only print the summary line.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->appState->setAreaCode('frontend');
        } catch (\Throwable) {
        }

        $output->writeln('<info>Starting cache warmup...</info>');

        $rows = [];
        $printRows = !$input->getOption('quiet-rows');
        $progress = $printRows
            ? function (array $row) use ($output, &$rows): void {
                $rows[] = $row;
                $statusFmt = $row['status'] === 'success' ? '<fg=green>OK</>' : '<fg=red>FAIL</>';
                $output->writeln(sprintf(
                    '  %s [%d %sms] %s',
                    $statusFmt,
                    $row['http_code'],
                    number_format((float) $row['response_time_ms'], 1),
                    $row['url']
                ));
            }
            : null;

        $startedAt = microtime(true);
        $results = $this->warmer->runWarmup($progress);
        $durationMs = (microtime(true) - $startedAt) * 1000.0;

        if (empty($results)) {
            $output->writeln('<comment>No URLs were warmed (page list empty or warmup not configured).</comment>');
            return Command::SUCCESS;
        }

        $okCount = 0;
        $failCount = 0;
        $totalRespMs = 0.0;
        foreach ($results as $row) {
            $totalRespMs += (float) $row['response_time_ms'];
            if ($row['status'] === 'success') {
                $okCount++;
            } else {
                $failCount++;
            }
        }
        $avg = $totalRespMs / max(1, count($results));

        if (!$printRows) {
            $table = new Table($output);
            $table->setHeaders(['Status', 'HTTP', 'ms', 'Page', 'URL']);
            foreach ($results as $row) {
                $table->addRow([
                    $row['status'] === 'success' ? 'OK' : 'FAIL',
                    (string) $row['http_code'],
                    number_format((float) $row['response_time_ms'], 1),
                    (string) $row['page_type'],
                    (string) $row['url'],
                ]);
            }
            $table->render();
        }

        $output->writeln(sprintf(
            '<info>Warmup complete:</info> %d OK, %d failed, avg %.1f ms/req, total wall %.1f ms.',
            $okCount,
            $failCount,
            $avg,
            $durationMs
        ));
        return $failCount === 0 ? Command::SUCCESS : Command::FAILURE;
    }
}
