namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class FKtest17 : DbMigration
    {
        public override void Up()
        {
            DropForeignKey("dbo.Booking", "GarageID", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "GarageID" });
            RenameColumn(table: "dbo.Booking", name: "GarageID", newName: "Garage_Id");
            AlterColumn("dbo.Booking", "Garage_Id", c => c.Int());
            CreateIndex("dbo.Booking", "Garage_Id");
            AddForeignKey("dbo.Booking", "Garage_Id", "dbo.Garages", "Id");
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Booking", "Garage_Id", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "Garage_Id" });
            AlterColumn("dbo.Booking", "Garage_Id", c => c.Int(nullable: false));
            RenameColumn(table: "dbo.Booking", name: "Garage_Id", newName: "GarageID");
            CreateIndex("dbo.Booking", "GarageID");
            AddForeignKey("dbo.Booking", "GarageID", "dbo.Garages", "Id", cascadeDelete: true);
        }
    }
}
