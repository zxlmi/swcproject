<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - The Best Pizza</title>
    <link rel="stylesheet" href="css/style.css"> 
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: black;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .faq-container {
            width: 80%;
            background: rgba(20, 20, 20, 0.95);
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
            animation: fadeIn 0.5s ease-in-out;
            margin-top: 20px;
            overflow-y: auto;
            max-height: 80vh;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #FFD700; /* Golden Yellow */
            font-size: 28px;
            margin-bottom: 15px;
        }

        .search-box {
            width: 100%;
            padding: 12px;
            border: 2px solid #FFD700;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
            background: black;
            color: white;
        }

        .search-box::placeholder {
            color: #FFD700;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        @media (min-width: 768px) {
            .faq-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .faq {
            border-bottom: 1px solid #FFD700;
            padding-bottom: 10px;
        }

        .question {
            font-weight: bold;
            cursor: pointer;
            padding: 12px;
            background: #B22222; /* Dark Red */
            color: white;
            border-radius: 5px;
            transition: 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .question:hover {
            background: #8B0000;
        }

        .answer {
            display: none;
            padding: 10px;
            background: rgba(255, 215, 0, 0.2);
            border-left: 3px solid #FFD700;
            border-radius: 5px;
            margin-top: 5px;
            color: white;
        }

        .toggle-dark-mode {
            position: absolute;
            top: 10px;
            right: 20px;
            background: #FFD700;
            color: black;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            border: none;
        }

        .toggle-dark-mode:hover {
            background: #FFA500;
        }
    </style>
</head>
<body>
    <button class="toggle-dark-mode" onclick="toggleDarkMode()">🌙 Dark Mode</button>
    
    <div class="faq-container">
        <h2>Frequently Asked Questions</h2>
        <input type="text" class="search-box" placeholder="Search FAQ..." onkeyup="searchFAQ()">
        
        <div class="faq-grid">
            <div class="faq">
                <div class="question">🍕 What is The Best Pizza? <span class="toggle">+</span></div>
                <div class="answer">The Best Pizza is your go-to place for delicious, handcrafted pizzas made with fresh ingredients and love!</div>
            </div>
            <div class="faq">
                <div class="question">🛵 Do you offer delivery services? <span class="toggle">+</span></div>
                <div class="answer">Yes! We offer fast and hot delivery right to your doorstep. Just place your order online!</div>
            </div>
            <div class="faq">
                <div class="question">💳 What payment methods do you accept? <span class="toggle">+</span></div>
                <div class="answer">We accept credit/debit cards, PayPal, and cash on delivery.</div>
            </div>
            <div class="faq">
                <div class="question">⏳ How long does delivery take? <span class="toggle">+</span></div>
                <div class="answer">Delivery usually takes 30-45 minutes depending on your location.</div>
            </div>
            <div class="faq">
                <div class="question">🏪 Do you have a physical store? <span class="toggle">+</span></div>
                <div class="answer">Yes! Visit our store at multiple locations across the city.</div>
            </div>
            <div class="faq">
                <div class="question">🔥 What are your best-selling pizzas? <span class="toggle">+</span></div>
                <div class="answer">Our bestsellers include Margherita, Pepperoni, and BBQ Chicken pizzas.</div>
            </div>
            <div class="faq">
                <div class="question">📦 Can I order in bulk for an event? <span class="toggle">+</span></div>
                <div class="answer">Yes, we offer bulk orders for parties and events with special discounts.</div>
            </div>
            <div class="faq">
                <div class="question">🍕 How do I reheat my pizza? <span class="toggle">+</span></div>
                <div class="answer">Reheat in an oven at 180°C for 5-7 minutes for best results.</div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.question').forEach(item => {
            item.addEventListener('click', () => {
                const answer = item.nextElementSibling;
                const toggle = item.querySelector('.toggle');
                answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
                toggle.innerText = answer.style.display === 'block' ? '-' : '+';
            });
        });

        function searchFAQ() {
            let input = document.querySelector('.search-box').value.toLowerCase();
            document.querySelectorAll('.faq').forEach(faq => {
                let questionText = faq.querySelector('.question').innerText.toLowerCase();
                faq.style.display = questionText.includes(input) ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
