namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class AddedDbVehicle : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Vehicles",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        TypeOfVehicle = c.String(nullable: false),
                    })
                .PrimaryKey(t => t.Id);
            
            AddColumn("dbo.Booking", "DbVehiclesId", c => c.Int());
            CreateIndex("dbo.Booking", "DbVehiclesId");
            AddForeignKey("dbo.Booking", "DbVehiclesId", "dbo.Vehicles", "Id");
            DropColumn("dbo.Booking", "TypeOfVehicle");
        }
        
        public override void Down()
        {
            AddColumn("dbo.Booking", "TypeOfVehicle", c => c.String(nullable: false));
            DropForeignKey("dbo.Booking", "DbVehiclesId", "dbo.Vehicles");
            DropIndex("dbo.Booking", new[] { "DbVehiclesId" });
            DropColumn("dbo.Booking", "DbVehiclesId");
            DropTable("dbo.Vehicles");
        }
    }
}
