<?php

$defaultIncludes = [];
$bootstrapPath = __DIR__ . '/include/bootstrap.php';
if (file_exists($bootstrapPath)) {
    $defaultIncludes[] = $bootstrapPath;
}

return [

    // PsySH uses symfony/var-dumper's casters for presenting scalars,
    // resources, arrays and objects. You can enable additional casters, or
    // write your own!
    'casters' => [
        'MyFooClass' => 'MyFooClassCaster::castMyFooObject',
    ],

    // By default, output contains colors if support for them is detected. To
    // override, use:
    //
    //   \Psy\Configuration::COLOR_MODE_FORCED to force colors
    //   \Psy\Configuration::COLOR_MODE_DISABLED to disable colors
    //   \Psy\Configuration::COLOR_MODE_AUTO to detect terminal support
    'colorMode' => \Psy\Configuration::COLOR_MODE_FORCED,

    // Provide a custom CodeCleaner instance or configuration to modify how user
    // input is validated and transformed before execution. This is an advanced
    // option for customizing PsySH's code transformation pipeline.
    // 'codeCleaner' => $myCustomCodeCleaner,

    // Override the clipboard command used by the `copy` command. Leave this
    // unset to auto-detect a supported clipboard command.
    // 'clipboardCommand' => 'pbcopy',

    // While PsySH ships with a bunch of great commands, it's possible to add
    // your own for even more awesome. Any Psy command added here will be
    // available in your Psy shell sessions.
    'commands' => [
        // The `parse` command is a command used in the development of PsySH.
        // Given a string of PHP code, it pretty-prints the PHP Parser parse
        // tree. It prolly won't be super useful for most of you, but it's there
        // if you want to play :)
        new \Psy\Command\ParseCommand,
    ],

    // Override the configuration directory location. By default, PsySH follows
    // the XDG Base Directory specification (~/.config/psysh on Unix-like
    // systems, %APPDATA%\PsySH on Windows).
    // 'configDir' => __DIR__ . '/config',

    // Override the data directory location where PsySH stores history and other
    // persistent data. By default, follows the XDG Base Directory specification
    // (~/.local/share/psysh on Unix-like systems, %APPDATA%\PsySH on Windows).
    // 'dataDir' => __DIR__ . '/data',

    // "Default includes" will be included once at the beginning of every PsySH
    // session. This is a good place to add autoloaders for your favorite
    // libraries.
    'defaultIncludes' => $defaultIncludes,

    // If set to true, the history will not keep duplicate entries. Newest
    // entries override oldest. This is the equivalent of the
    // `HISTCONTROL=erasedups` setting in bash.
    'eraseDuplicates' => false,

    // While PsySH respects the current `error_reporting` level, and doesn't
    // throw exceptions for all errors, it does log all errors regardless of
    // level. Set `errorLoggingLevel` to `0` to prevent logging non-thrown
    // errors. Set it to any valid `error_reporting` value to log only errors
    // which match that level.
    'errorLoggingLevel' => E_ALL & ~E_NOTICE,

    // Add extra structured exception details to exception output. The callback
    // receives the thrown exception and may return any dumpable value.
    // 'exceptionDetails' => static function (\Throwable $e) {
    //     return ['class' => $e::class];
    // },

    // Always show array indexes (even for numeric arrays).
    'forceArrayIndexes' => true,

    // Sets the maximum number of entries the history can contain. If set to
    // zero, the history size is unlimited.
    'historySize' => 0,

    // Automatically add use statements for unqualified class references. When
    // you reference a class by its short name (e.g., `User`) and there's
    // exactly one match in configured namespaces, PsySH automatically adds the
    // use statement. Works great with `warmAutoload` to make class references
    // feel natural.
    'implicitUse' => [
        'includeNamespaces' => ['MarcoConsiglio\\Goniometry\\'],
        'excludeNamespaces' => ['App\\Legacy\\'],
    ],

    // PsySH defaults to interactive mode in a terminal, and non-interactive
    // mode when input is coming from a pipe.  To override, use:
    //
    //   \Psy\Configuration::INTERACTIVE_MODE_FORCED for interactive mode
    //   \Psy\Configuration::INTERACTIVE_MODE_DISABLED for non-interactive mode
    //   \Psy\Configuration::INTERACTIVE_MODE_AUTO to choose by connection type
    'interactiveMode' => \Psy\Configuration::INTERACTIVE_MODE_FORCED,

    // Log user input, commands, and executed code to a PSR-3 compatible logger
    // or callback. Useful for audit trails and debugging.
    // 'logging' => [
    //     'logger' => null,
    //     'level' => [
    //         'input'   => 'info',   // User code input
    //         'command' => 'info',   // PsySH commands (ls, doc, etc.)
    //         'execute' => 'debug',  // Cleaned code before execution
    //     ],
    // ],
    // Or use a simple callback:
    'logging' => function ($kind, $data) {
        file_put_contents('/tmp/psysh.log', "[$kind] $data\n", FILE_APPEND);
    },

    // Override the location of the PHP manual database file used by the `doc`
    // command. By default, this is stored in the data directory.
    // 'manualDbFile' => __DIR__ . '/data/php_manual.sqlite',

    // You can write your own tab completion matchers, too! Here are some that
    // enable tab completion for MongoDB database and collection names:
    'matchers' => [
        new \Psy\TabCompletion\Matcher\MongoClientMatcher,
        new \Psy\TabCompletion\Matcher\MongoDatabaseMatcher,
    ],

    // Set a custom output pager command for PsySH. Set this to `false` to
    // disable paging, or leave it unset to use `cli.pager` / `less`.
    'pager' => 'more',

    // Specify a custom prompt. Deprecated; prefer `theme.prompt`.
    'prompt' => '>>>',

    // Print var_export-style return values.
    //
    // This is set by the --raw-output (-r) flag, and really only makes sense
    // when non-interactive, e.g. executing stdin.
    'rawOutput' => false,

    // PsySH automatically inserts semicolons at the end of input if a statement
    // is missing one. To disable this, set `requireSemicolons` to true.
    'requireSemicolons' => true,

    // Suppress return value display when input ends with an unnecessary
    // trailing semicolon. The value is still assigned to `$_`. Set to 'double'
    // to require `;;` instead.
    'semicolonsSuppressReturn' => true,

    // Set the shell's temporary directory location. Defaults to `/psysh` inside
    // the system's temp dir unless explicitly overridden.
    'runtimeDir' => __DIR__ . '/tmp',

    // Display an additional startup message. You can color and style the
    // message thanks to the Symfony Console tags. See
    // https://symfony.com/doc/current/console/coloring.html for more details.
    'startupMessage' => sprintf('<info>%s</info>', shell_exec('uptime')),

    // Enforce strict types by default. When enabled, all code executed in PsySH
    // will run with `declare(strict_types=1)` behavior.
    'strictTypes' => false,

    // Control whether PsySH trusts the current project. Untrusted projects run
    // in Restricted Mode, which skips loading local config (.psysh.php), local
    // PsySH binaries, and Composer autoloads.
    //
    //   \Psy\Configuration::PROJECT_TRUST_PROMPT to ask interactively
    //   \Psy\Configuration::PROJECT_TRUST_ALWAYS to trust all projects
    //   \Psy\Configuration::PROJECT_TRUST_NEVER to always run restricted
    'trustProject' => 'prompt',

    // PsySH supports output themes, which control prompt strings, formatter
    // styles and colors, and compact output.
    //
    // There are three built-in themes: `modern`, `compact` or `classic`, which
    // can be specified directly:
    //
    //   'theme' => 'classic'
    'theme' => [
        // Use compact output. This can also be set by the --compact flag.
        'compact' => true,

        // The standard input prompt.
        'prompt' => '> ',

        // The input prompt used for multi-line input continuation.
        'bufferPrompt' => '. ',

        // Output prefix indicating lines replayed from history.
        'replayPrompt' => '- ',

        // Output prefix indicating the evaluated input's return value.
        'returnValue' => '= ',

        // Override theme formatting colors.
        //
        // Available colors:
        //   black, red, green, yellow, blue, magenta, cyan, white and default.
        // Available options:
        //   bold, underscore, blink, reverse and conceal.
        //
        // Note that the exact effect of these colors and options on output
        // depends on your terminal emulator application and settings.
        'styles' => [
            // name => [foreground, background, [options]],
            'error' => ['black', 'red', ['bold']],
        ],
    ],

    // Frequency of update checks when starting an interactive shell session.
    // Valid options are "always", "daily", "weekly", and "monthly".
    //
    // To disable update checks entirely, set to "never".
    'updateCheck' => 'daily',

    // Frequency of PHP manual update checks.
    // Valid options are "always", "daily", "weekly", "monthly", and "never".
    'updateManualCheck' => 'weekly',

    // Temporary compatibility flag to keep the old triple-quoted multiline
    // string output format. Leave this disabled to use the newer heredoc-style
    // output.
    'useDeprecatedMultilineStrings' => false,

    // Enable experimental interactive readline: a pure-PHP readline
    // replacement with syntax-aware completions, multi-line editing, fuzzy
    // matching, reverse history search, and more. No ext-readline required.
    'useExperimentalReadline' => true,

    // Disable live syntax and command highlighting in interactive readline.
    // 'useSyntaxHighlighting' => false,

    // Enable inline autosuggestions (fish-style ghost text) in interactive
    // readline. Still a bit rough around the edges.
    // 'useSuggestions' => true,

    // Enable bracketed paste support when the active readline implementation
    // supports it.
    'useBracketedPaste' => true,

    // Use OSC 52 escape sequences for clipboard copy support. Useful over SSH
    // when your terminal supports it.
    'useOsc52Clipboard' => false,

    // By default, PsySH will use a 'forking' execution loop if pcntl is
    // installed. This is by far the best way to use it, but you can override
    // the default by explicitly disabling this functionality here.
    'usePcntl' => true,

    // PsySH uses readline if you have it installed, because interactive input
    // is pretty awful without it. But you can explicitly disable it if you hate
    // yourself or something.
    //
    // If readline is disabled (or unavailable) then terminal input is subject
    // to the line discipline provided for TTYs by the OS, which may impose a
    // maximum line size (4096 chars in GNU/Linux, for example) with larger
    // lines being truncated before reaching PsySH.
    'useReadline' => true,

    // You can disable tab completion if you want to. Not sure why you'd
    // want to.
    'useTabCompletion' => true,

    // PsySH uses a couple of UTF-8 characters in its own output. These can be
    // disabled, mostly to work around code page issues. Because Windows.
    //
    // Note that this does not disable Unicode output in general, it just makes
    // it so PsySH won't output any itself.
    'useUnicode' => true,

    // Change output verbosity. This is equivalent to the `--verbose`, `-vv`,
    // `-vvv` and `--quiet` command line flags. Choose from:
    //
    //   \Psy\Configuration::VERBOSITY_QUIET (this is *really* quiet)
    //   \Psy\Configuration::VERBOSITY_NORMAL
    //   \Psy\Configuration::VERBOSITY_VERBOSE
    //   \Psy\Configuration::VERBOSITY_VERY_VERBOSE
    //   \Psy\Configuration::VERBOSITY_DEBUG
    'verbosity' => \Psy\Configuration::VERBOSITY_VERBOSE,

    // Enable autoload warming to improve command support and tab completion.
    // When enabled PsySH will pre-load classes at startup, making them
    // available to tab completion and commands like `ls`, `doc` and `show`.
    //
    // If `true`, this is equivalent to the `--warm-autoload` command line flag.
    'warmAutoload' => [
        'includeVendor' => true, // Include vendor packages
        'includeTests' => true,  // Include test classes

        // Include (or exclude) specific namespaces
        // 'includeNamespaces' => ['App\\', 'Lib\\'],
        'includeNamespaces' => ['MarcoConsiglio\\Goniometry\\'],
        // 'excludeNamespaces' => ['App\\Legacy\\'],
        'excludeNamespaces' => [],

        // Include (or exclude) specific vendor namespaces
        // 'includeVendorNamespaces' => ['Symfony\\Component\\', 'Doctrine\\'],
        // 'excludeVendorNamespaces' => ['Symfony\\VarDumper\\'],

        // Custom warmers can be implemented via `AutoloadWarmerInterface`
        // 'warmers' => [new MyCustomWarmer()],
    ],

    // If multiple versions of the same configuration or data file exist, PsySH
    // will use the file with highest precedence, and will silently ignore all
    // others. With this enabled, a warning will be emitted (but not an
    // exception thrown) if multiple configuration or data files are found.
    //
    // This will default to true in a future release, but is false for now.
    'warnOnMultipleConfigs' => true,

    // Run PsySH without input validation. You don't want to set this to true.
    'yolo' => false,
];