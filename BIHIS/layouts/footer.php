    </div><!-- End container-fluid -->
</div><!-- End page -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- For dashboard charts -->
<script src="assets/js/functions.js"></script>

<!-- Page-specific scripts -->
<?php if(isset($page_scripts)): ?>
    <?php foreach($page_scripts as $script): ?>
        <script src="assets/js/<?php echo $script; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>