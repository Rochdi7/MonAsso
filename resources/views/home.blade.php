<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Villas Beach Tennis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Villas Beach Tennis — área do sócio, eventos e mensalidades.">
    <link rel="icon" href="{{ asset('assets/images/logo/villas.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/style-preset.css') }}">
    <style>
        :root {
            --villas-navy: #33436f;
            --villas-lime: #a9c93c;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            color: #1f2937;
            background: #fff;
        }

        .v-nav {
            max-width: 1080px;
            margin: 0 auto;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .v-nav img {
            height: 56px;
        }

        .v-hero {
            background: linear-gradient(160deg, #f8faf1 0%, #eaf1da 100%);
            border-top: 1px solid #eef1e8;
            border-bottom: 1px solid #e3e8d8;
        }

        .v-hero-inner {
            max-width: 1080px;
            margin: 0 auto;
            padding: 72px 24px 80px;
            display: grid;
            gap: 40px;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
        }

        .v-hero h1 {
            font-size: 2.6rem;
            line-height: 1.15;
            font-weight: 700;
            color: var(--villas-navy);
            margin-bottom: 16px;
        }

        .v-hero p {
            font-size: 1.1rem;
            color: #4b5563;
            margin-bottom: 28px;
            max-width: 46ch;
        }

        .v-hero img {
            width: 100%;
            max-width: 340px;
            margin: 0 auto;
            display: block;
            border-radius: 24px;
            box-shadow: 0 24px 48px rgba(51, 67, 111, .12);
        }

        .v-btn {
            display: inline-block;
            padding: 13px 26px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .v-btn-primary {
            background: var(--villas-navy);
            color: #fff;
        }

        .v-btn-primary:hover {
            background: #28355a;
            color: #fff;
        }

        .v-btn-lime {
            background: var(--villas-lime);
            color: #24301a;
        }

        .v-btn-lime:hover {
            background: #98b734;
            color: #24301a;
        }

        .v-info {
            max-width: 1080px;
            margin: 0 auto;
            padding: 64px 24px;
        }

        .v-cards {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(3, 1fr);
        }

        .v-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 26px;
            background: #fff;
        }

        .v-card h3 {
            font-size: 1.05rem;
            color: var(--villas-navy);
            margin-bottom: 8px;
        }

        .v-card p {
            color: #6b7280;
            margin: 0;
            font-size: .95rem;
        }

        .v-footer {
            border-top: 1px solid #e5e7eb;
            padding: 24px;
            text-align: center;
            color: #6b7280;
            font-size: .9rem;
        }

        @media (max-width: 820px) {
            .v-hero-inner {
                grid-template-columns: 1fr;
                padding: 48px 24px 56px;
                text-align: center;
            }

            .v-hero h1 {
                font-size: 2rem;
            }

            .v-hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .v-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav class="v-nav">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo/villas.jpg') }}" alt="Villas Beach Tennis">
            </a>
            @auth
                <a href="{{ url('dashboard') }}" class="v-btn v-btn-lime">Área do sócio</a>
            @else
                <a href="{{ route('login') }}" class="v-btn v-btn-lime">Área do sócio</a>
            @endauth
        </nav>
    </header>

    <main>
        <section class="v-hero">
            <div class="v-hero-inner">
                <div>
                    <h1>Bem-vindo ao Villas Beach Tennis</h1>
                    <p>
                        Espaço dos sócios do clube: acompanhe suas mensalidades, eventos,
                        reuniões e avisos da diretoria.
                    </p>
                    <a href="{{ route('login') }}" class="v-btn v-btn-primary">Entrar na área do sócio</a>
                </div>
                <div>
                    <img src="{{ asset('assets/images/logo/villas.jpg') }}" alt="Villas Beach Tennis">
                </div>
            </div>
        </section>

        <section class="v-info">
            <div class="v-cards">
                <div class="v-card">
                    <h3>Mensalidades</h3>
                    <p>Consulte o que já foi pago, o que está em aberto e os recibos emitidos pelo clube.</p>
                </div>
                <div class="v-card">
                    <h3>Eventos</h3>
                    <p>Veja o calendário de torneios, jogos e confraternizações do clube.</p>
                </div>
                <div class="v-card">
                    <h3>Reuniões</h3>
                    <p>Acompanhe as atas e os assuntos tratados nas reuniões da diretoria.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="v-footer">
        &copy; {{ date('Y') }} Villas Beach Tennis
    </footer>
</body>

</html>
