<?php

$bundles = [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\UX\StimulusBundle\StimulusBundle::class => ['all' => true],
    Symfony\UX\Turbo\TurboBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Symfonycasts\TailwindBundle\SymfonycastsTailwindBundle::class => ['all' => true],
    NetBrothers\NbCsbBundle\NetBrothersNbCsbBundle::class => ['dev' => true, 'test' => true],
];

// Register custom bundles only if their classes are available (supports installing packages separately)
if (class_exists(\Mms7SymfonyPakieciarnia\StronaGlownaBundle\StronaGlownaBundle::class)) {
    $bundles[\Mms7SymfonyPakieciarnia\StronaGlownaBundle\StronaGlownaBundle::class] = ['all' => true];
}

if (class_exists(\Mms7SymfonyPakieciarnia\ArchiwistaBundle\ArchiwistaBundle::class)) {
    $bundles[\Mms7SymfonyPakieciarnia\ArchiwistaBundle\ArchiwistaBundle::class] = ['all' => true];
}

return $bundles;

