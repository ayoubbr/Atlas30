@extends('user.layout')

@section('title', 'World Cup 2030 - Tickets & Fan Community')

@section('css')
    <style>
        /* Countdown Section */
        .countdown {
            background-color: var(--secondary);
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .countdown-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent);
        }

        .countdown-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            margin-bottom: 15px;
        }

        /* Upcoming Matches */
        .matches {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .matches-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .match-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .match-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .match-details {
            padding: 20px;
        }

        .match-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .match-flag {
            width: 60px;
            height: 40px;
            margin-bottom: 10px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
        }

        .match-vs {
            font-weight: 700;
            color: var(--primary);
        }

        .match-info {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .match-date,
        .match-venue {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #666;
        }

        .match-date i,
        .match-venue i {
            margin-right: 5px;
            color: var(--primary);
        }

        .match-cta {
            margin-top: 15px;
            text-align: center;
        }

        /* Community Section */
        .community {
            padding: 80px 0;
            background-color: white;
        }

        .community-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .community-image {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .community-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .community-text h2 {
            margin-bottom: 20px;
        }

        .community-text p {
            margin-bottom: 30px;
        }

        .community-features {
            margin-bottom: 30px;
        }

        .community-feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .community-feature i {
            color: var(--success);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Newsletter */
        .newsletter {
            padding: 60px 0;
            background-color: var(--primary);
            color: white;
            text-align: center;
        }

        .newsletter h2 {
            color: white;
            margin-bottom: 20px;
        }

        .newsletter p {
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-form input {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 4px 0 0 4px;
            font-size: 1rem;
        }

        .newsletter-form button {
            padding: 12px 20px;
            background-color: var(--accent);
            color: var(--dark);
            border: none;
            border-radius: 0 4px 4px 0;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .newsletter-form button:hover {
            background-color: #dab10d;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.8rem;
            }

            .community-content {
                grid-template-columns: 1fr;
            }

            .community-image {
                order: 1;
            }

            .community-text {
                order: 2;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .countdown-container {
                flex-wrap: wrap;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-form input {
                border-radius: 4px;
                margin-bottom: 10px;
            }

            .newsletter-form button {
                border-radius: 4px;
            }
        }

        @media (max-width: 576px) {
            .hero {
                height: 70vh;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .countdown-number {
                font-size: 1.8rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>World Cup 2030 Tickets & Fan Community</h1>
                <p>Join the global celebration of football. Get your tickets and connect with fans from around the
                    world.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn">Buy Tickets</a>
                    <a href="#" class="btn btn-accent">Join Community</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="countdown">
        <div class="container">
            <h2>Countdown to Kickoff</h2>
            <div class="countdown-container">
                <div class="countdown-item">
                    <div class="countdown-number">365</div>
                    <div class="countdown-label">Days</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number">24</div>
                    <div class="countdown-label">Hours</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number">60</div>
                    <div class="countdown-label">Minutes</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number">60</div>
                    <div class="countdown-label">Seconds</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Us</h2>
                <p>The ultimate platform for World Cup 2030 fans</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3>Secure Ticketing</h3>
                    <p>Purchase official match tickets with guaranteed authenticity and secure transactions.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Fan Community</h3>
                    <p>Connect with millions of football fans, share experiences, and make new friends.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>Travel Planning</h3>
                    <p>Get assistance with accommodation, transportation, and local guides for match venues.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Matches -->
    <section class="matches">
        <div class="container">
            <div class="section-title">
                <h2>Upcoming Matches</h2>
                <p>Secure your tickets for the most anticipated matches</p>
            </div>
            <div class="matches-grid">
                <div class="match-card">
                    <div class="match-image"
                        style="background-image: url('https://ichef.bbci.co.uk/images/ic/1200x675/p0g3pgmf.jpg')">
                    </div>
                    <div class="match-details">
                        <div class="match-teams">
                            <div class="match-team">
                                <div class="match-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/3498db/ffffff?text=Team+A')">
                                </div>
                                <div class="match-name">Brazil</div>
                            </div>
                            <div class="match-vs">VS</div>
                            <div class="match-team">
                                <div class="match-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/e74c3c/ffffff?text=Team+B')">
                                </div>
                                <div class="match-name">France</div>
                            </div>
                        </div>
                        <div class="match-info">
                            <div class="match-date">
                                <i class="far fa-calendar-alt"></i> June 15, 2030
                            </div>
                            <div class="match-venue">
                                <i class="fas fa-map-marker-alt"></i> Rio Stadium
                            </div>
                        </div>
                        <div class="match-cta">
                            <a href="#" class="btn">Get Tickets</a>
                        </div>
                    </div>
                </div>
                <div class="match-card">
                    <div class="match-image"
                        style="background-image: url('https://ichef.bbci.co.uk/images/ic/640x360/p0dgf5kf.jpg')">
                    </div>
                    <div class="match-details">
                        <div class="match-teams">
                            <div class="match-team">
                                <div class="match-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/2ecc71/ffffff?text=Team+C')">
                                </div>
                                <div class="match-name">Germany</div>
                            </div>
                            <div class="match-vs">VS</div>
                            <div class="match-team">
                                <div class="match-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/f39c12/ffffff?text=Team+D')">
                                </div>
                                <div class="match-name">Spain</div>
                            </div>
                        </div>
                        <div class="match-info">
                            <div class="match-date">
                                <i class="far fa-calendar-alt"></i> June 18, 2030
                            </div>
                            <div class="match-venue">
                                <i class="fas fa-map-marker-alt"></i> Berlin Arena
                            </div>
                        </div>
                        <div class="match-cta">
                            <a href="#" class="btn">Get Tickets</a>
                        </div>
                    </div>
                </div>
                <div class="match-card">
                    <div class="match-image"
                        style="background-image: url('https://i.ytimg.com/vi/8h_VAG-rnD0/maxresdefault.jpg')">
                    </div>
                    <div class="match-details">
                        <div class="match-teams">
                            <div class="match-team">
                                <div class="match-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/9b59b6/ffffff?text=Team+E')">
                                </div>
                                <div class="match-name">Argentina</div>
                            </div>
                            <div class="match-vs">VS</div>
                            <div class="match-team">
                                <div class="match-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/34495e/ffffff?text=Team+F')">
                                </div>
                                <div class="match-name">England</div>
                            </div>
                        </div>
                        <div class="match-info">
                            <div class="match-date">
                                <i class="far fa-calendar-alt"></i> June 21, 2030
                            </div>
                            <div class="match-venue">
                                <i class="fas fa-map-marker-alt"></i> London Stadium
                            </div>
                        </div>
                        <div class="match-cta">
                            <a href="#" class="btn">Get Tickets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section class="community">
        <div class="container">
            <div class="community-content">
                <div class="community-text">
                    <h2>Join Our Global Fan Community</h2>
                    <p>Connect with millions of football enthusiasts from around the world. Share your passion, discuss
                        matches, and make lasting friendships.</p>
                    <div class="community-features">
                        <div class="community-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Create fan groups based on teams or countries</span>
                        </div>
                        <div class="community-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Share photos and videos from matches</span>
                        </div>
                        <div class="community-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Organize meetups with other fans</span>
                        </div>
                        <div class="community-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Participate in discussions and predictions</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-secondary">Join Community</a>
                </div>
                <div class="community-image">
                    <img src="https://assets.publishing.service.gov.uk/media/619df21d8fa8f5037b09c5ef/Fans_clapping.jpg"
                        alt="Football Fans">
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <h2>Stay Updated</h2>
            <p>Subscribe to our newsletter to receive the latest news, ticket releases, and special offers for the World
                Cup 2030.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>
@endsection

@section('js')
    <!-- JavaScript for Countdown -->
    <script>
        // You can implement the actual countdown functionality here
        // This is just a placeholder for now
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }

            // Countdown functionality
            const countdownNumbers = document.querySelectorAll('.countdown-number');

            // Set the World Cup date (example: June 8, 2030)
            const worldCupDate = new Date('June 8, 2030 00:00:00').getTime();

            // Update the countdown every second
            const countdownTimer = setInterval(function() {
                // Get today's date and time
                const now = new Date().getTime();

                // Find the distance between now and the World Cup date
                const distance = worldCupDate - now;

                // Time calculations for days, hours, minutes and seconds
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the results
                if (countdownNumbers.length >= 4) {
                    countdownNumbers[0].textContent = days;
                    countdownNumbers[1].textContent = hours;
                    countdownNumbers[2].textContent = minutes;
                    countdownNumbers[3].textContent = seconds;
                }

                // If the countdown is finished, display a message
                if (distance < 0) {
                    clearInterval(countdownTimer);
                    document.querySelector('.countdown-container').innerHTML =
                        "<h2>The World Cup Has Begun!</h2>";
                }
            }, 1000);
        });
    </script>
@endsection