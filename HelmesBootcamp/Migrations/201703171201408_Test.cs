namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class Test : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Booking",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        Car = c.String(nullable: false),
                        Garage = c.String(nullable: false),
                        TypeOfVehicle = c.String(nullable: false),
                        StartDateTime = c.DateTime(nullable: false),
                        EndTime = c.Time(nullable: false, precision: 7),
                        LicensePlateNumber = c.String(nullable: false, maxLength: 9),
                        CustomersPhoneNumber = c.Int(nullable: false),
                        TyreHotel = c.Boolean(nullable: false),
                        Information = c.String(),
                    })
                .PrimaryKey(t => t.Id);
            
            CreateTable(
                "dbo.Garages",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        Name = c.String(nullable: false),
                        Address = c.String(nullable: false),
                        TyreHotel = c.String(nullable: false),
                    })
                .PrimaryKey(t => t.Id);
            
        }
        
        public override void Down()
        {
            DropTable("dbo.Garages");
            DropTable("dbo.Booking");
        }
    }
}
