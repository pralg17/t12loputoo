namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class FKtest16 : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Booking",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        GarageID = c.Int(nullable: false),
                        TypeOfVehicle = c.String(nullable: false),
                        StartDateTime = c.DateTime(nullable: false),
                        EndTime = c.Time(nullable: false, precision: 7),
                        LicensePlateNumber = c.String(nullable: false, maxLength: 9),
                        CustomersPhoneNumber = c.Int(nullable: false),
                        TyreHotel = c.Boolean(nullable: false),
                        Information = c.String(),
                        Edited = c.DateTime(),
                        Canceled = c.DateTime(),
                    })
                .PrimaryKey(t => t.Id)
                .ForeignKey("dbo.Garages", t => t.GarageID, cascadeDelete: true)
                .Index(t => t.GarageID);
            
            CreateTable(
                "dbo.Garages",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        GarageName = c.String(nullable: false, maxLength: 15),
                        Address = c.String(nullable: false, maxLength: 200),
                        TyreHotel = c.Boolean(nullable: false),
                    })
                .PrimaryKey(t => t.Id);
            
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Booking", "GarageID", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "GarageID" });
            DropTable("dbo.Garages");
            DropTable("dbo.Booking");
        }
    }
}
