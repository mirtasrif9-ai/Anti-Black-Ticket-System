<?php require 'include/_tickets.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets - Chorolin Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/tickets.css">
    <style>
    .ticket-modal-overlay { position: fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:1000; }
    .ticket-modal { background:#fff; border-radius:12px; box-shadow:0 8px 32px rgba(0,0,0,0.2); max-width:400px; width:95vw; padding:24px 18px 18px 18px; position:relative; }
    .ticket-modal-close { position:absolute; top:10px; right:16px; font-size:1.3em; color:#888; cursor:pointer; }
    .ticket-modal .qr { display:flex; justify-content:center; margin:18px 0; }
    .ticket-modal .modal-label { font-weight:600; color:#2563eb; }
    .ticket-modal .modal-row { margin-bottom:10px; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<body>
    <?php include 'include/nav.php'; ?>
    <main>
        <h1><i class="fas fa-ticket"></i> <?php echo $role == 'admin' ? 'All Tickets' : 'My Tickets'; ?></h1>
        <div class="tickets-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($ticket = $result->fetch_assoc()): ?>
                <div class="ticket-card">
                    <div class="ticket-header">
                        <span class="ticket-id">Ticket #<?php echo $ticket['ticket_id']; ?></span>
                        <span class="status-badge status-<?php echo $ticket['ticket_status']; ?>">
                            <?php echo ucfirst($ticket['ticket_status']); ?>
                        </span>
                    </div>

                    <div class="ticket-route">
                        <?php echo htmlspecialchars($ticket['from_station']) . ' → ' . htmlspecialchars($ticket['to_station']); ?>
                    </div>

                    <?php if ($role == 'admin'): ?>
                        <div class="ticket-info">
                            <span class="ticket-info-label">Passenger:</span> <?php echo htmlspecialchars($ticket['name']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="ticket-info">
                        <span class="ticket-info-label">Travel Date:</span>
                        <?php echo date('d M Y', strtotime($ticket['travel_date'])); ?>
                    </div>

                    <div class="ticket-info">
                        <span class="ticket-info-label">Class:</span> <?php echo htmlspecialchars($ticket['class']); ?>
                    </div>

                    <div class="ticket-info">
                        <span class="ticket-info-label">Passengers:</span> <?php echo $ticket['passengers_count']; ?>
                        (<?php
                            $names = json_decode($ticket['passenger_names'], true);
                            if (is_array($names)) {
                                echo implode(', ', array_map('htmlspecialchars', $names));
                            } else {
                                echo htmlspecialchars($ticket['passenger_names']);
                            }
                            ?>)
                    </div>

                    <div class="ticket-info">
                        <span class="ticket-info-label">Total Fare:</span> ৳<?php echo number_format($ticket['total_fare'], 2); ?>
                    </div>

                    <div class="ticket-actions">
                        <?php if ($role == 'admin'): ?>
                            <form method="POST">
                                <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                <select name="new_status">
                                    <option value="pending" <?php echo $ticket['ticket_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="confirmed" <?php echo $ticket['ticket_status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="canceled" <?php echo $ticket['ticket_status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                                    <option value="expired" <?php echo $ticket['ticket_status'] == 'expired' ? 'selected' : ''; ?>>Expired</option>
                                </select>
                                <button type="submit" name="update_status" class="action-btn">Update</button>
                            </form>
                        <?php elseif ($ticket['ticket_status'] == 'pending'): ?>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this ticket?')">
                                <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                <button type="submit" name="cancel_ticket" class="action-btn cancel-btn">Cancel</button>
                            </form>
                        <?php elseif ($ticket['ticket_status'] == 'confirmed'): ?>
                            <button class="action-btn" style="background-color:rgb(2, 112, 37); font-weight:900;" onclick='showTicketModal(<?php echo json_encode([
                                "ticket_id"=>$ticket["ticket_id"],
                                "from_station"=>$ticket["from_station"],
                                "to_station"=>$ticket["to_station"],
                                "travel_date"=>$ticket["travel_date"],
                                "class"=>$ticket["class"],
                                "passengers_count"=>$ticket["passengers_count"],
                                "passenger_names"=>$ticket["passenger_names"],
                                "total_fare"=>$ticket["total_fare"],
                                "name"=>isset($ticket["name"])?$ticket["name"]:null,
                                "email"=>isset($ticket["email"])?$ticket["email"]:null,
                                "phone_number"=>isset($ticket["phone_number"])?$ticket["phone_number"]:null,
                                "status"=>$ticket["ticket_status"]
                            ]); ?>)'>Show your ticket</button>
                        <?php else: ?>
                        <a href="tickets.php?download=1&id=<?php echo $ticket['ticket_id']; ?>" class="download-btn">
                            <i class="fas fa-download"></i> Download
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <div class="no-tickets">
                <i class="fas fa-ticket-alt"></i>
                <p>No tickets found</p>
                <a href="trains.php" class="action-btn">Book a ticket now</a>
            </div>
        <?php endif; ?>
        </div>
    </main>
    <?php include 'include/footer.php'; ?>

    <!-- Ticket Modal -->
    <div class="ticket-modal-overlay" id="ticketModalOverlay">
      <div class="ticket-modal" id="ticketModal">
        <span class="ticket-modal-close" onclick="closeTicketModal()">&times;</span>
        <h2 style="text-align:center; color:#2563eb; margin-bottom:10px;">Your Ticket</h2>
        <div class="modal-row"><span class="modal-label">Ticket #</span> <span id="modalTicketId"></span></div>
        <div class="modal-row"><span class="modal-label">Passenger Names:</span> <span id="modalNames"></span></div>
        <!-- <div class="modal-row"><span class="modal-label">Name:</span> <span id="modalName"></span></div> -->
        <div class="modal-row"><span class="modal-label">From:</span> <span id="modalFrom"></span></div>
        <div class="modal-row"><span class="modal-label">To:</span> <span id="modalTo"></span></div>
        <div class="modal-row"><span class="modal-label">Travel Date:</span> <span id="modalDate"></span></div>
        <div class="modal-row"><span class="modal-label">Class:</span> <span id="modalClass"></span></div>
        <div class="modal-row"><span class="modal-label">Passengers:</span> <span id="modalPassengers"></span></div>
        
        <div class="modal-row"><span class="modal-label">Total Fare:</span> <span id="modalFare"></span></div>
        <div class="modal-row"><span class="modal-label">Status:</span> <span id="modalStatus"></span></div>
        <div class="qr" id="modalQr"></div>
      </div>
    </div>
    <script>
    function showTicketModal(ticket) {
      document.getElementById('modalTicketId').textContent = ticket.ticket_id;
      //document.getElementById('modalName').textContent = ticket.name || '';
      document.getElementById('modalFrom').textContent = ticket.from_station;
      document.getElementById('modalTo').textContent = ticket.to_station;
      document.getElementById('modalDate').textContent = ticket.travel_date;
      document.getElementById('modalClass').textContent = ticket.class;
      document.getElementById('modalPassengers').textContent = ticket.passengers_count;
      let names = ticket.passenger_names;
      try { names = JSON.parse(names); } catch(e) {}
      if(Array.isArray(names)) names = names.join(', ');
      document.getElementById('modalNames').textContent = names;
      document.getElementById('modalFare').textContent = '৳' + parseFloat(ticket.total_fare).toFixed(2);
      document.getElementById('modalStatus').textContent = ticket.status;
      document.getElementById('ticketModalOverlay').style.display = 'flex';
      let now = new Date();
let hours = String(now.getHours()).padStart(2, '0');
let minutes = String(now.getMinutes()).padStart(2, '0');
let seconds = String(now.getSeconds()).padStart(2, '0');
let currentTime = `${hours}${minutes}`;
      // Generate QR code (encode ticket id + name + date)
      let qrData = `${ticket.ticket_id}${ticket.passenger_names||''}
      
      From:${ticket.from_station}
      To:${ticket.to_station}
      Date:${ticket.travel_date}
      Security:***${currentTime}`;
      document.getElementById('modalQr').innerHTML = '';
      new QRCode(document.getElementById('modalQr'), {
        text: qrData,
        width: 150,
        height: 150,
 
      });
    }
    function closeTicketModal() {
      document.getElementById('ticketModalOverlay').style.display = 'none';
    }
    </script>
</body>

</html>