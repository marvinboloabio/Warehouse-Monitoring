<?php
class Deliveries
{
    private $conn;
    private $table = 'deliveries';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* public function getSuppliers()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY delivery_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        **/

    public function getSuppliers()
    {
        $query = "SELECT 
                d.*,
                i.item_code,
                i.item_description AS item_name
              FROM " . $this->table . " d
              INNER JOIN items i 
                ON d.item_description = i.item_id
              ORDER BY d.delivery_id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveSuppliers()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'Active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSupplier($data)
    {
        $query = "INSERT INTO " . $this->table . " (
        item_description, 
        date_receive,
        transaction_type,
        weight_scale,
        dynamics_qty,
        truckscale_vs_dynamics,
        five_tonner,
        num_bag,
        tonner_vs_truck,
        tord_no,
        atw_no,
        pallet_qty,
        supplier,
        plate_no,
        weigh_slip,
        status,
        trucking_service,
        remarks
    ) VALUES (
        :item_description,
        :date_receive,
        :transaction_type,
        :weight_scale,
        :dynamics_qty,
        :truckscale_vs_dynamics,
        :five_tonner,
        :num_bag,
        :tonner_vs_truck,
        :tord_no,
        :atw_no,
        :pallet_qty,
        :supplier,
        :plate_no,
        :weigh_slip,
        :status,
        :trucking_service,
        :remarks
    )";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function updateSupplier($data)
    {
        $query = "UPDATE " . $this->table . " SET
        item_description = :item_description,
        date_receive = :date_receive,
        transaction_type = :transaction_type,
        weight_scale = :weight_scale,
        dynamics_qty = :dynamics_qty,
        truckscale_vs_dynamics = :truckscale_vs_dynamics,
        five_tonner = :five_tonner,
        num_bag = :num_bag,
        tonner_vs_truck = :tonner_vs_truck,
        tord_no = :tord_no,
        atw_no = :atw_no,
        pallet_qty = :pallet_qty,
        supplier = :supplier,
        plate_no = :plate_no,
        weigh_slip = :weigh_slip,
        status = :status,
        trucking_service = :trucking_service,
        remarks = :remarks,
        updated_at = CURRENT_TIMESTAMP
    WHERE delivery_id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}
