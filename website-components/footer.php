<footer>
    <!-- Footer: Add copyright message and social links -->
    <p>
        &copy; <span id="copyrightYear">
            <script>document.getElementById('copyrightYear').textContent = new Date().getFullYear();</script>
        </span> Plug & Play. Alle rechten voorbehouden.
    </p>
    <div class="social-icons">
        <?php 
        $socialLinks = [
            'facebook' => 'https://www.facebook.com',
            'youtube' => 'https://www.youtube.com',
            'instagram' => 'https://www.instagram.com',
            'linkedin' => 'https://www.linkedin.com'
        ];
        foreach ($socialLinks as $platform => $url): ?>
            <a href="<?= $url ?>" target="_blank" aria-label="<?= ucfirst($platform) ?>">
                <img src="images/footer/<?= $platform ?>-icon.png" alt="<?= ucfirst($platform) ?>" class="social-icon">
            </a>
        <?php endforeach; ?>
    </div>
</footer>