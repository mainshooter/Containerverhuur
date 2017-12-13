<form method="post">
  <label>Begin datum</label>
  <input type="date" name="startDate" required>
  <br>
  <label>Eind datum</label>
  <input type="date" name="endDate" required>
  <br>

  <label>Vaste klant</label>
  <input type="checkbox" name="regularCustomer" required>
  <br></br>
  <label>Container inhoud</label>
  <input type="number" name="content" required>
  <br>
  <input type="submit" name="calulate" value="Bereken">
</form>

<?php
  $days = 0;
  $regularCustomer = false;
  $containerContent = 0;

  if (ISSET($_POST['calulate'])) {
    if (checkIfCustomerIsRegular()) {
      // 15 discount
      $result = (calculatePriceEmpting() + calculatePriceForAllDays()) * 0.85;
    }

    else {
      // No discount
      $result = (calculatePriceEmpting() + calculatePriceForAllDays());
    }
    echo "Het kost: &euro;" . $result;
  }

  function calculatePriceForAllDays() {
    return(intval(getDays()) * 40 * intval(getContainerContent()));
  }

  /**
   * Calculates how much it cost the emprty the container
   * @return [int] [The price of how much it costs]
   */
  function calculatePriceEmpting() {
    if (getContainerContent() >= 2) {
      return(60);
    }

    else {
      return(125);
    }
  }

  /**
   * Gets the amount
   * @return [type] [description]
   */
  function getContainerContent() {
    global $containerContent;

    $containerContent = $_POST['content'];
    return($containerContent);
  }

  function getDays() {
    global $days;

    $startDate = $_POST['startDate'];
    $startDate = date($startDate);


    $endDate = $_POST['endDate'];
    $endDate = date($endDate);

    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    $interval = $startDate->diff($endDate);
    return($interval->format('%a '));
  }

  /**
   * Checks if we have a regular customer
   * @return [boolean] [If it is, we return true]
   */
  function checkIfCustomerIsRegular() {
    global $regularCustomer;

    if ($_POST['regularCustomer'] == 'on') {
      $regularCustomer = true;
      return(true);
    }
    else {
      $regularCustomer = false;
      return(false);
    }
  }



?>
